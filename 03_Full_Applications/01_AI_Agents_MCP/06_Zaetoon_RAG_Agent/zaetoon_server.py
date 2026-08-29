import os
from dotenv import load_dotenv
from mcp.server.fastmcp import FastMCP
from openai import OpenAI

import rag_helpers as rag
import zaetoon_helpers as zaetoon

load_dotenv()

groq_key = os.getenv("GROQ_API_KEY") or os.getenv("GPT_KEY")

if not groq_key:
    raise ValueError("Groq API key missing! Set GROQ_API_KEY in your .env file.")

api_key = os.getenv("GPT_KEY")
client_gpt = OpenAI(
    base_url="https://api.groq.com/openai/v1",
    api_key=os.getenv("GROQ_API_KEY")
)

articles_json_file = os.getenv("articles_json_file", "data/articles.json").strip()
chroma_store_path = os.getenv("chroma_store_path", "data/chroma_store").strip()
chroma_db_name = os.getenv("chroma_db_name", "articles_db").strip()
embedding_model_name = os.getenv(
    "embedding_model_name", "sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2"
).strip()
gpt_model_name = os.getenv("gpt_model_name", "gpt-4o").strip()
ai_agent_id = os.getenv("ai_agent_id", "2398").strip()

mcp = FastMCP("zaetoon")


@mcp.prompt(name="find_team_prompt", description="موجه إيجاد الفريق المناسب لرسالة عميل")
def find_team_prompt():
    return """
        أنت مساعد ذكي نستخدمه لفهم رسالة العميل وإرسالها إلى الفريق المختص المناسب لمعالجة الرسالة.
        يجب أن تُعيد فقط أحد أسماء الفرق التالية:
        الصيانة | المالية | المتابعة

        لا تزيد أي شرح أو تعليق فقط واحد من الكلمات الثلاثة السابقة.

        التعليمات:
        - إذا كان موضوع الرسالة يتعلق بعطل أو طلب إصلاح أو صيانة فأعد: الصيانة
        - إذا كان موضوع الرسالة يتعلق بأمر مالي مثل السعر أو الفاتورة أو الحسم أو العروض المالية أو غيرها من الأمور المالية فأعد: المالية
        - وفي الحالات الأخرى التي لاتتعلق لا بالمالية و لا بالصيانة أعد: المتابعة
        """


@mcp.tool(name="find_team_tool", description="أداة إيجاد الفريق المناسب لرسالة عميل")
def find_team_tool(msg):
    try:
        system_prompt = find_team_prompt()

        llm_response = client_gpt.chat.completions.create(
            model=gpt_model_name,
            messages=[
                {"role": "system", "content": system_prompt},
                {"role": "user", "content": msg},
            ],
            temperature=0,
        )

        return llm_response.choices[0].message.content.strip()

    except Exception as e:
        raise RuntimeError(f"Unexpected error from GPT: {e}")


@mcp.tool(name="handle_conversations", description="معالجة المحادثات")
def handle_conversations():
    inbox_ids = zaetoon.get_all_inbox_ids()
    teams_names = zaetoon.get_team_names()

    for inbox_id in inbox_ids:
        open_convs_ids = zaetoon.get_open_unassigned_conversations_ids(inbox_id)
        agent_id_conversations_ids = zaetoon.get_open_agent_id_conversations_ids(
            inbox_id, ai_agent_id
        )

        for c in agent_id_conversations_ids:
            if c not in open_convs_ids:
                open_convs_ids.append(c)

        if not open_convs_ids:
            continue

        for conv_id in open_convs_ids:
            conversation, msg = zaetoon.get_conversation_text(conv_id)

            if not msg:
                continue

            rag_answer = rag.answer_client_rag(
                conversation,
                msg,
                chroma_store_path,
                chroma_db_name,
                embedding_model_name,
                gpt_model_name,
            )

            if rag_answer and "لا أعرف" not in rag_answer and "لاأعرف" not in rag_answer:
                zaetoon.assign_conversation_agent(conv_id, ai_agent_id)
                zaetoon.send_conversation_msg(conv_id, rag_answer)
                continue

            proposed_team = find_team_tool(msg)

            if proposed_team not in teams_names:
                proposed_team = "المتابعة"

            zaetoon.assign_conversation_team_round_robin(proposed_team, conv_id)

            answer = "شكرا لتواصلك سيقوم أحد موظفينا بالتواصل معك قريبا"
            zaetoon.send_conversation_msg(conv_id, answer)


if __name__ == "__main__":
    try:
        zaetoon.get_all_articles(articles_json_file)
        rag.build_chromadb(articles_json_file, chroma_store_path, chroma_db_name, embedding_model_name)

        mcp.run(transport="sse")

    except KeyboardInterrupt:
        print("\n MCP server stopped by user (Ctrl+C)")

    except Exception as e:
        print(f" حدث خطأ: {e}")
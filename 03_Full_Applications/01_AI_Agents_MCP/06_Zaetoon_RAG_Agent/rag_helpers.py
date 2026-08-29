import json
import os
import chromadb
from chromadb.utils import embedding_functions
from dotenv import load_dotenv
from openai import OpenAI

load_dotenv()

groq_key = os.getenv("GROQ_API_KEY") or os.getenv("GPT_KEY")

if not groq_key:
    raise ValueError("Groq API key is missing! Set GROQ_API_KEY in your .env file.")

client_gpt = OpenAI(
    base_url="https://api.groq.com/openai/v1",
    api_key=groq_key,
)


def build_chromadb(articles_json_file, chroma_store_path, chroma_db_name, embedding_model_name):
    os.makedirs(chroma_store_path, exist_ok=True)
    os.makedirs(os.path.dirname(articles_json_file), exist_ok=True)

    client = chromadb.PersistentClient(path=chroma_store_path)

    try:
        client.delete_collection(chroma_db_name)
    except Exception:
        pass

    collection = client.create_collection(
        name=chroma_db_name,
        embedding_function=embedding_functions.SentenceTransformerEmbeddingFunction(
            model_name=embedding_model_name
        ),
    )

    if not os.path.exists(articles_json_file):
        print(f"الملف {articles_json_file} غير موجود حتى الآن.")
        return

    with open(articles_json_file, "r", encoding="utf-8") as f:
        articles = json.load(f)

    for art in articles:
        content = art.get("content", "").strip()
        if not content:
            continue
        collection.add(
            documents=[content],
            metadatas=[{"title": art.get("title", "")}],
            ids=[str(art.get("id"))],
        )


def answer_client_rag(
    conversation,
    msg,
    chroma_store_path,
    chroma_db_name,
    embedding_model_name,
    gpt_model_name,
    top_k=2,
):
    try:
        client = chromadb.PersistentClient(path=chroma_store_path)
        collection = client.get_collection(
            name=chroma_db_name,
            embedding_function=embedding_functions.SentenceTransformerEmbeddingFunction(
                model_name=embedding_model_name
            ),
        )

        query_text = f"{conversation}\n{msg}".strip()
        results = collection.query(query_texts=[query_text], n_results=top_k)

        if not results["documents"] or not results["documents"][0]:
            return "لا أعرف"

        kb_text = ""
        for meta, doc in zip(results["metadatas"][0], results["documents"][0]):
            t = meta.get("title", "")
            kb_text += f"\n### {t}\n{doc}\n" if t else f"\n{doc}\n"

        prompt = f"""
            أنت مساعد دعم فني عربي.
            مهمتك استخراج الإجابة المناسبة لسؤال العميل الأخير اعتمادًا على المحادثات السابقة وقاعدة المعرفة.

            الإجابات الممكنة:
            - "كيف يمكنني مساعدتك"
            - "لا أعرف"
            - الجواب المناسب من قاعدة المعرفة (مختصر أو مفصل حسب طلب العميل)

            القواعد:
            - إذا كان سؤال العميل الأخير تحية أو شكر أو سلام فقط (بدون أي استفسار) ← أجب: "كيف يمكنني مساعدتك".
            - إذا كان سؤال العميل الأخير طلب متابعة مثل ("لم أفهم" أو "أعطني تفاصيل أكثر" أو "وضح لي") ← 
            أعِد صياغة الجواب السابق من المحادثات السابقة مع المزيد من التفاصيل (باستخدام نفس قاعدة المعرفة).
            - إذا كان سؤال العميل الأخير استفسارًا أو طلبًا جديدًا:
            1. استخدم المحادثات السابقة لفهم السياق:
            {conversation}
            2. ثم ابحث في قاعدة المعرفة:
            {kb_text}
            - إذا وجدت جوابًا مناسبًا ← أجب به.
            - إذا لم تجد أي جواب مناسب ← أجب: "لا أعرف".

            سؤال العميل الأخير:
            {msg}

            التزم بالآتي:
            - أجب بالعربية فقط.
            - لا تضف أي تفاصيل غير موجودة.
            - لا تكرر سؤال العميل.
            - لا تضف مقدمات أو شروحات.
            - اجعل الإجابة واضحة ومباشرة (مختصرة أو مفصلة حسب ما يطلب العميل).
            """

        response = client_gpt.chat.completions.create(
            model=gpt_model_name,
            messages=[{"role": "user", "content": prompt}],
            temperature=0,
        )

        if response.choices:
            return response.choices[0].message.content.strip()

        return "لم يتمكن الموديل من إرجاع إجابة"

    except Exception as e:
        return f"حصل خطأ أثناء الاستدعاء: {e}"
import asyncio
import json
import os
import re
import sys
from telegram import Update
from telegram.ext import ApplicationBuilder, ContextTypes, MessageHandler, filters
from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client
from ollama import AsyncClient


def extract_tool_args(raw_text: str):
    clean_text = re.sub(r'//.*', '', raw_text)
    match = re.search(r'\{.*\}', clean_text, re.DOTALL)
    
    if not match:
        return None, {}
    try:
        data = json.loads(match.group())
        return data.get("tool"), data.get("args", {})
    except json.JSONDecodeError:
        return None, {}


async def classify_and_execute(session: ClientSession, user_id: str, message: str) -> str:
    try:
        # Get dynamic prompt from MCP server
        prompt = await session.get_prompt("ecommerce_prompt", {"user_input": message})
        prompt_text = prompt.messages[0].content.text

        # Non-blocking async Ollama execution
        client = AsyncClient()
        response = await client.chat(
            model="gemma2",
            messages=[{"role": "system", "content": prompt_text}]
        )

        raw = response["message"]["content"].strip()
        tool, args = extract_tool_args(raw)

        if not tool:
            res = await session.read_resource("resource://custom_data_snippet_resource")
            return res.contents[0].text.strip()

        args = args or {}
        args["user_id"] = str(user_id)

        # Call MCP Tool
        result = await session.call_tool(tool, args)
        return (result.content[0].text or "").strip()

    except Exception as e:
        return f"حدث خطأ أثناء تنفيذ الطلب:\n{e}"


async def handle_message(update: Update, context: ContextTypes.DEFAULT_TYPE):
    if not update.message or not update.message.text:
        return

    user_text = update.message.text.strip()
    user_id = str(update.effective_user.id)
    session: ClientSession = context.bot_data["mcp_session"]

    reply = await classify_and_execute(session, user_id, user_text)
    await update.message.reply_text(reply or "لم يصلني رد من الخدمة.")


async def main():
    # تحديد المسار المطلق لملف السيرفر في نفس مجلد السكريبت
    script_dir = os.path.dirname(os.path.abspath(__file__))
    server_script = os.path.join(script_dir, "ecommerce_server.py")

    # استخدام نفس مفسر بيثون الحالي لتشغيل السيرفر بدلاً من uv
    server_params = StdioServerParameters(
        command=sys.executable,
        args=[server_script]
    )

    # Maintain single persistent stdio connection & session
    async with stdio_client(server_params) as (reader, writer):
        async with ClientSession(reader, writer) as session:
            await session.initialize()

            # Retrieve bot token once at startup
            token_res = await session.read_resource("resource://telegram_token_resource")
            token = token_res.contents[0].text.strip() if token_res.contents else ""
            
            if not token:
                raise RuntimeError("لم يتم العثور على TELEGRAM_TOKEN")

            app = ApplicationBuilder().token(token).build()
            
            # Store session in bot_data for global access inside handlers
            app.bot_data["mcp_session"] = session
            app.add_handler(MessageHandler(filters.TEXT & ~filters.COMMAND, handle_message))

            print("🤖 البوت شغّال الآن… اضغط Ctrl+C للإيقاف.")
            
            async with app:
                await app.start()
                await app.updater.start_polling()
                await asyncio.Event().wait()


if __name__ == "__main__":
    try:
        asyncio.run(main())
    except (KeyboardInterrupt, SystemExit):
        print("\nتمّ إيقاف البوت")
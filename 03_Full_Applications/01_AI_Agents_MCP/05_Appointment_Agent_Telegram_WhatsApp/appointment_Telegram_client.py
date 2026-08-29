import asyncio
import json
import os
import re
import sys

from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client
import ollama
from telegram import Update
from telegram.ext import ApplicationBuilder, ContextTypes, MessageHandler, filters

# Resolve absolute path and working directory
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
SERVER_SCRIPT = os.path.join(BASE_DIR, "appointment_server.py")


def get_server_params() -> StdioServerParameters:
    """إعداد بارامترات تشغيل سيرفر MCP باستخدام مفسر Python الحالي."""
    return StdioServerParameters(
        command=sys.executable,
        args=[SERVER_SCRIPT],
        cwd=BASE_DIR
    )


async def get_token_from_mcp() -> str:
    params = get_server_params()

    async with stdio_client(params) as (reader, writer):
        async with ClientSession(reader, writer) as session:
            await session.initialize()

            res = await session.read_resource("resource://telegram_token_resource")
            try:
                return res.contents[0].text.strip()
            except Exception:
                return ""


def extract_tool_args(raw_text: str):
    clean_text = re.sub(r"//.*", "", raw_text)
    match = re.search(r"\{.*\}", clean_text, re.DOTALL)
    if not match:
        return None, {}
    try:
        data = json.loads(match.group())
        return data.get("tool"), data.get("args", {})
    except json.JSONDecodeError:
        return None, {}


async def classify_and_execute(user_identifier: str, message: str) -> str:
    params = get_server_params()

    try:
        async with stdio_client(params) as (reader, writer):
            async with ClientSession(reader, writer) as session:
                await session.initialize()

                prompt = await session.get_prompt(
                    "appointment_prompt", {"user_input": message}
                )
                prompt_text = prompt.messages[0].content.text

                response = ollama.chat(
                    model="gemma2",
                    messages=[{"role": "system", "content": prompt_text}],
                )

                raw = response["message"]["content"].strip()
                tool, args = extract_tool_args(raw)

                if not tool:
                    tool = "default_response"

                args = args or {}
                args["mobile"] = user_identifier
                args["user_input"] = message

                result = await session.call_tool(tool, args)
                if result.content:
                    return result.content[0].text.strip()
                return "لم يصلني رد من الخدمة."

    except Exception as e:
        print(f"Telegram execution error: {e}")
        return f"حدث خطأ أثناء تنفيذ الطلب:\n{e}"


async def handle_message(update: Update, context: ContextTypes.DEFAULT_TYPE) -> None:
    if not update.message or not update.message.text:
        return

    user_text = update.message.text.strip()
    user = update.effective_user
    user_identifier = str(user.id)

    reply = await classify_and_execute(user_identifier, user_text)
    await update.message.reply_text(reply)


async def main():
    token = await get_token_from_mcp()

    if not token:
        raise RuntimeError("لم يتم العثور على TELEGRAM_TOKEN في إعدادات MCP Server.")

    app = ApplicationBuilder().token(token).build()

    app.add_handler(
        MessageHandler(filters.TEXT & ~filters.COMMAND, handle_message)
    )

    print("🤖 البوت شغّال الآن… اضغط Ctrl+C للإيقاف.")
    await app.initialize()
    await app.start()
    await app.updater.start_polling()

    await asyncio.Event().wait()


if __name__ == "__main__":
    try:
        asyncio.run(main())
    except (KeyboardInterrupt, SystemExit):
        print("\nتمّ إيقاف البوت")
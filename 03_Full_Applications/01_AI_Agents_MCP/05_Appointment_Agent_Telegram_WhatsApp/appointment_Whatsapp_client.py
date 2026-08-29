import asyncio
import json
import os
import re
from threading import Thread

from flask import Flask, Response, request
from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client
import ollama
from pyngrok import ngrok
from twilio.twiml.messaging_response import MessagingResponse

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
SERVER_SCRIPT = os.path.join(BASE_DIR, "appointment_server.py")


def clean_message(text: str) -> str:
    text = re.sub(r"[\U0001F300-\U0001FAFF]", "", text)
    text = re.sub(r"[\x00-\x1F\x7F-\x9F]", "", text)
    text = re.sub(r"\s+", " ", text).strip()
    return text


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


async def classify_and_execute(mobile: str, message: str) -> str:
    server_params = StdioServerParameters(
        command="uv", args=["run", SERVER_SCRIPT]
    )

    try:
        async with stdio_client(server_params) as (reader, writer):
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
                args["mobile"] = mobile.replace("whatsapp:", "").strip()
                args["user_input"] = message

                result = await session.call_tool(tool, args)
                if result.content:
                    return result.content[0].text.strip()
                return "تم تنفيذ الطلب بنجاح."

    except Exception as e:
        print(f"Execution Error: {e}")
        return f"حدث خطأ أثناء تنفيذ الطلب:\n{e}"


app = Flask(__name__)

@app.route("/", methods=["GET"])
def home():
    return "سيرفر البوت يعمل بنجاح!", 200

@app.route("/webhook", methods=["POST"])
def webhook():
    text = request.values.get("Body", "") or ""
    mobile = request.values.get("From", "") or ""

    result = asyncio.run(classify_and_execute(mobile, text))
    cleaned = clean_message(result) or "عذرًا، لم أفهم رسالتك. يرجى المحاولة مجددًا."

    resp = MessagingResponse()
    resp.message(cleaned)
    return Response(str(resp), mimetype="application/xml")


def run_flask():
    app.run(host="0.0.0.0", port=5000)


if __name__ == "__main__":
    tunnel = ngrok.connect(5000)
    print("Use this as Twilio webhook:", tunnel.public_url + "/webhook")

    Thread(target=run_flask, daemon=True).start()
    input("Press Enter to stop...\n")
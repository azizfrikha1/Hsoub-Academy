import asyncio
import json
from pathlib import Path
import re
import sys
import ollama
from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client

# Centralized model variable set as a string
MODEL_NAME = "gemma2"

history = []

async def classify_user_input_with_server_prompt(session: ClientSession, history: list[dict]) -> dict:
    full_history = "\n".join([f"You: {msg['content']}" for msg in history if msg["role"] == "user"])

    try:
        prompt_result = await session.get_prompt("weather_classifier", {"natural_input": full_history})
        prompt_text = prompt_result.messages[0].content.text.strip()
    except Exception as e:
        print("❌ Error fetching prompt from server:", e)
        return {"tool": "none"}

    response = ollama.chat(
        model=MODEL_NAME,
        messages=[{"role": "system", "content": prompt_text}] + history
    )

    raw = response["message"]["content"].strip()
    json_match = re.search(r'(\{.*\})', raw, re.DOTALL)
    
    if not json_match:
        return {"tool": "none"}
    
    try:
        return json.loads(json_match.group(1))
    except Exception:
        return {"tool": "none"}

async def main():
    server_script = Path(__file__).parent / "weather_server_ollama.py"

    # Use sys.executable to run the server in the current .venv Python process
    server_params = StdioServerParameters(
        command=sys.executable,
        args=[str(server_script)]
    )

    async with stdio_client(server_params) as (reader, writer):
        async with ClientSession(reader, writer) as session:
            await session.initialize()
            print("Weather Assistant Ready! (Type 'q' to quit)\n")

            while True:
                user_input = input("You: ").strip()
                
                if user_input.lower() in {"q", "quit", "exit"}:
                    print("Goodbye!")
                    break

                history.append({"role": "user", "content": user_input})

                parsed = await classify_user_input_with_server_prompt(session, history)

                if parsed.get("tool") == "get_current_weather":
                    args = parsed.get("args", {})
                    result = await session.call_tool("get_current_weather", args)
                    print("\n🌤️ Weather Report:")
                    print(result.content[0].text.strip(), "\n")
                    history.append({"role": "assistant", "content": result.content[0].text.strip()})

                elif parsed.get("tool") == "get_forecast":
                    args = parsed.get("args", {})
                    result = await session.call_tool("get_forecast", args)
                    print("\n📅 Forecast Report:")
                    print(result.content[0].text.strip(), "\n")
                    history.append({"role": "assistant", "content": result.content[0].text.strip()})

                else:
                    response = ollama.chat(
                        model=MODEL_NAME,
                        messages=history
                    )
                    answer = response["message"]["content"].strip()
                    print("\n💬 Assistant:", answer, "\n")
                    history.append({"role": "assistant", "content": answer})

if __name__ == "__main__":
    asyncio.run(main())
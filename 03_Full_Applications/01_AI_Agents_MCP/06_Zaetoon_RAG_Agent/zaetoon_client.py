import asyncio
from datetime import datetime
import os
from dotenv import load_dotenv
from mcp import ClientSession
from mcp.client.sse import sse_client

load_dotenv()

MCP_URL = os.getenv("MCP_URL", "http://127.0.0.1:8000/sse")


async def main():
    try:
        async with sse_client(MCP_URL) as (reader, writer):
            async with ClientSession(reader, writer) as session:
                await session.initialize()
                print(" Connected to MCP Server via SSE")

                while True:
                    try:
                        resp = await session.call_tool("handle_conversations")
                        if resp and resp.content:
                            print(resp.content[0].text)

                        print(f"[{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] handle_conversations executed")
                    except Exception as e:
                        print(f"[{datetime.now().strftime('%Y-%m-%d %H:%M:%S')}] Error while calling tool: {e}")

                    await asyncio.sleep(15)

    except Exception as e:
        print(f" حدث خطأ أثناء الاتصال بالسيرفر:\n{e}")


if __name__ == "__main__":
    try:
        asyncio.run(main())
    except KeyboardInterrupt:
        print("\n Client stopped manually.")
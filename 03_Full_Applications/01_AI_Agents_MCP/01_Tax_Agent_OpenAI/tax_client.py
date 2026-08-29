import asyncio
import json
from pathlib import Path
from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client

# Helper function to prevent input() from blocking the asyncio event loop
async def ainput(prompt: str = "") -> str:
    return await asyncio.to_thread(input, prompt)

async def main():
    # Resolve the path to tax_server.py in the same folder
    server_path = Path(__file__).parent / "tax_server.py"

    server_params = StdioServerParameters(
        command="python",
        args=[str(server_path)]
    )

    async with stdio_client(server_params) as (reader, writer):
        async with ClientSession(reader, writer) as session:
            await session.initialize()
            print("Connected to MCP Tax Server successfully.\n")

            while True:
                print("\n=== MENU ===")
                print("1. Calculate Tax (calculate_tax)")
                print("2. Tax Greeting (tax_greeting)")
                print("3. View All VAT Settings")
                print("4. Quit")
                
                choice = (await ainput("Select an option (1/2/3/4): ")).strip()

                if choice == "4":
                    print("Exiting client...")
                    break

                elif choice == "1":
                    raw_price = await ainput("Enter price: ")
                    try:
                        price = float(raw_price)
                    except ValueError:
                        print("Error: Please enter a valid numerical price.")
                        continue

                    country = (await ainput("Enter country: ")).strip()

                    try:
                        response = await session.call_tool(
                            "calculate_tax", 
                            {"price": price, "country": country}
                        )
                        print(f"\nCalculated Tax: {response.content[0].text.strip()}")
                    except Exception as e:
                        print(f"\nError: {e}")

                elif choice == "2":
                    name = (await ainput("Enter your name: ")).strip()
                    country = (await ainput("Enter country: ")).strip()

                    try:
                        prompt_result = await session.get_prompt(
                            "tax_greeting", 
                            {"name": name, "country": country}
                        )
                        print(f"\nMessage: {prompt_result.messages[0].content.text.strip()}")
                    except Exception as e:
                        print(f"\nError: {e}")

                elif choice == "3":
                    try:
                        resource_data = await session.read_resource("resource://tax_config")
                        resource_text = resource_data.contents[0].text
                        
                        # Handle string or dict resource response
                        data = json.loads(resource_text) if isinstance(resource_text, str) else resource_text

                        print("\nAvailable VAT Settings:")
                        for country, vat in data.items():
                            print(f"- {country}: {vat}%")
                    except Exception as e:
                        print(f"\nError reading resource: {e}")

                else:
                    print("Invalid option, please try again.")

if __name__ == "__main__":
    asyncio.run(main())
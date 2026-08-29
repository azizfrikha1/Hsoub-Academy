from fastmcp import FastMCP

mcp = FastMCP("WeatherAssistant")

@mcp.tool(name="get_current_weather")
def get_current_weather(city: str) -> str:
    """Gets current weather for a specified city."""
    return f"The current weather in {city} is 24°C and Sunny."

@mcp.tool(name="get_forecast")
def get_forecast(city: str) -> str:
    """Gets 3-day weather forecast for a specified city."""
    return f"3-Day Forecast for {city}:\n- Day 1: 25°C, Clear\n- Day 2: 22°C, Rain\n- Day 3: 20°C, Wind"

@mcp.prompt(name="weather_classifier", description="Classifies natural query into a weather tool call JSON, using context if needed.")
def weather_classifier_prompt(natural_input: str) -> str:
    return f"""You are a helpful AI that converts multi-turn user conversations into structured tool calls.

Available tools:
- get_current_weather(city: str)
- get_forecast(city: str)

Instructions:
- Use previous conversation turns to understand references like "tomorrow", "there", or "that city".
- Always extract the most relevant city and map it to a tool.
- Only respond with a valid JSON matching the exact schema below.

Examples:
Q: What's the weather like in Cairo today?
-> {{"tool": "get_current_weather", "args": {{"city": "Cairo"}}}}

Q: I want the forecast for Rome.
-> {{"tool": "get_forecast", "args": {{"city": "Rome"}}}}

If you can't extract a valid tool and city, respond with:
{{"tool": "none"}}

Conversation so far:
{natural_input}
"""

if __name__ == "__main__":
    mcp.run()
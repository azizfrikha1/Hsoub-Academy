from mcp.server.fastmcp import FastMCP
import httpx
from typing import Any

mcp = FastMCP("weather")

@mcp.resource("resource://weather_config_resource")
def weather_config_resource():
    return {
        "base_url": "https://api.openweathermap.org/data/2.5",
        "api_key": "4420e177b85d451d829d6389e11de37f"
    }

async def make_owm_request(
    endpoint: str,
    params: dict[str, Any],
    weather_config: dict[str, Any]
) -> dict[str, Any] | None:

    weather_config=weather_config_resource()
    base_url = weather_config.get("base_url")
    api_key = weather_config.get("api_key")

    if not api_key:
        print("[ERROR] Missing OpenWeatherMap API key.")
        return None

    params["appid"] = api_key
    params["units"] = "metric"

    try:
        async with httpx.AsyncClient() as client:
            url = f"{base_url}/{endpoint}"
            
            print(f"[INFO] Requesting: {url} with params {params}")
            
            response = await client.get(url, params=params, timeout=30.0)

            response.raise_for_status() 

            return response.json()       
    
    except Exception as e:
        print(f"[ERROR] OpenWeatherMap request failed: {e}")
        return None

@mcp.tool()
async def get_current_weather(city: str, weather_config: dict[str, Any] = None) -> str:

    if weather_config is None:
        weather_config=weather_config_resource()

    data = await make_owm_request(endpoint="weather", params={"q": city}, weather_config=weather_config)
    if not data:
        return f"ERROR: Could not retrieve current weather for '{city}'."

    main = data.get("main", {})

    weather = data.get("weather", [{}])[0]

    wind = data.get("wind", {})

    sys = data.get("sys", {})
 
    city_name = data.get("name", city)

    country = sys.get("country", "")

    temperature = main.get("temp", "?")

    humidity = main.get("humidity", "?")

    wind_speed = wind.get("speed", "?")

    description = weather.get("description", "N/A").capitalize()

    return (
        f"Current Weather in {city_name}, {country}:\n"
        f"Temperature: {temperature}°C\n"
        f"Humidity: {humidity}%\n"
        f"Wind: {wind_speed} m/s\n"
        f"Outlook: {description}"
    )
@mcp.tool()
async def get_forecast(city: str, weather_config: dict[str, Any] = None) -> str:

    if weather_config is None:
        weather_config = weather_config_resource()

    data = await make_owm_request(endpoint="forecast", params={"q": city}, weather_config=weather_config)
    if not data or "list" not in data:
        return f"ERROR: Unable to fetch forecast for '{city}'."

    city_info = data.get("city", {})

    forecasts = []

    for entry in data["list"][:5]:

        main = entry.get("main", {})

        weather_info = entry.get("weather", [{}])[0]

        wind = entry.get("wind", {})

        timestamp = entry.get("dt_txt", "")

        temp = main.get("temp", "?")

        wind_speed = wind.get("speed", "?")

        description = weather_info.get("description", "N/A").capitalize()

        forecast_text = (
            f"{timestamp}:\n"
            f"Temperature: {temp}°C\n"
            f"Wind: {wind_speed} m/s\n"
            f"Outlook: {description}\n"
        )

        forecasts.append(forecast_text)


    city_name = city_info.get("name", city)

    country = city_info.get("country", "")

    header = f"City: {city_name}, {country}"
    return header + "\n" + "\n---\n".join(forecasts)

if __name__ == "__main__":
    mcp.run(transport="stdio")
import os
from datetime import datetime, timedelta
import calendar_functions as cal

# Absolute path positioning relative to current file location
BASE_DIR = os.path.dirname(os.path.abspath(__file__))

SCOPES = ["https://www.googleapis.com/auth/calendar"]
CREDENTIALS_FILE = os.path.join(BASE_DIR, "credentials.json")
TOKEN_FILE = os.path.join(BASE_DIR, "token.json")

mobile1 = "1111"
mobile2 = "2222"

tz_name = "Africa/Tunis"
tomorrow = (datetime.now() + timedelta(days=1)).strftime("%Y-%m-%d")

if __name__ == "__main__":
    # 1. Schedule appointment for mobile1
    print(cal.schedule_appointment(SCOPES, CREDENTIALS_FILE, TOKEN_FILE, date=tomorrow, mobile=mobile1, tz_name=tz_name))

    # 2. Schedule appointment for mobile2
    print(cal.schedule_appointment(SCOPES, CREDENTIALS_FILE, TOKEN_FILE, date=tomorrow, mobile=mobile2, tz_name=tz_name))

    # 3. Retrieve appointments for mobile1
    print(cal.get_appointments(SCOPES, CREDENTIALS_FILE, TOKEN_FILE, mobile=mobile1))

    # 4. Cancel appointment for mobile2
    print(cal.cancel_appointment(SCOPES, CREDENTIALS_FILE, TOKEN_FILE, date=tomorrow, mobile=mobile2, tz_name=tz_name))

    # 5. Verify remaining appointments
    print(cal.get_appointments(SCOPES, CREDENTIALS_FILE, TOKEN_FILE, mobile=mobile1))
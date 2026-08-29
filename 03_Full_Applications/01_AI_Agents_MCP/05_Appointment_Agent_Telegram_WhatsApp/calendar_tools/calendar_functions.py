import os
import pytz
from typing import List
from datetime import datetime, timedelta, timezone

from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
from google.oauth2.credentials import Credentials
from googleapiclient.discovery import build, Resource


def get_arabic_weekday(dt: datetime) -> str:
    weekdays = {
        'Monday': 'الاثنين',
        'Tuesday': 'الثلاثاء',
        'Wednesday': 'الأربعاء',
        'Thursday': 'الخميس',
        'Friday': 'الجمعة',
        'Saturday': 'السبت',
        'Sunday': 'الأحد'
    }
    return weekdays.get(dt.strftime('%A'), '')


def get_calendar_service(SCOPES: List[str], CREDENTIALS_FILE: str, TOKEN_FILE: str) -> Resource:
    creds = None

    if os.path.exists(TOKEN_FILE):
        creds = Credentials.from_authorized_user_file(TOKEN_FILE, SCOPES)

    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file(CREDENTIALS_FILE, SCOPES)
            creds = flow.run_local_server(port=0)

        with open(TOKEN_FILE, "w") as token:
            token.write(creds.to_json())

    return build("calendar", "v3", credentials=creds)


def schedule_appointment(
    SCOPES: List[str],
    CREDENTIALS_FILE: str,
    TOKEN_FILE: str,
    date: str,
    mobile: str,
    tz_name: str = "Africa/Tunis",
    start_hour: int = 10,
    start_minute: int = 0,
    end_hour: int = 17,
    minutes: int = 30,
) -> str:
    try:
        try:
            base_date = datetime.strptime(date, "%Y-%m-%d").date()
        except ValueError:
            return "تنسيق التاريخ غير صحيح. استخدم YYYY-MM-DD."

        tz = pytz.timezone(tz_name)
        now_local = datetime.now(tz)

        # Prevent booking in the past
        if base_date < now_local.date():
            return "لا يمكن الحجز في تاريخ/وقت سابق."

        start_date_time = datetime.combine(base_date, datetime.min.time())
        day_start_local = tz.localize(start_date_time)
        day_end_local = day_start_local + timedelta(days=1)

        day_start = day_start_local.astimezone(pytz.utc).isoformat().replace("+00:00", "Z")
        day_end = day_end_local.astimezone(pytz.utc).isoformat().replace("+00:00", "Z")

        service = get_calendar_service(SCOPES, CREDENTIALS_FILE, TOKEN_FILE)

        events = service.events().list(
            calendarId='primary',
            timeMin=day_start,
            timeMax=day_end,
            singleEvents=True,
            orderBy='startTime'
        ).execute().get('items', [])

        if any(mobile in e.get("summary", "") for e in events):
            return f"لديك بالفعل موعد محجوز في {date}."

        taken_starts = set()
        for e in events:
            s = e.get('start', {})
            start_str = s.get('dateTime') or s.get('date')
            if start_str:
                dt_local = datetime.fromisoformat(start_str).astimezone(tz)
                dt_local = dt_local.replace(second=0, microsecond=0)
                taken_starts.add(dt_local)

        total_minutes = (end_hour - start_hour) * 60
        slots = int(total_minutes / minutes)

        start_base = tz.localize(
            datetime.combine(base_date, datetime.min.time()).replace(
                hour=start_hour, minute=start_minute, second=0, microsecond=0
            )
        )

        start_dt = None
        for i in range(slots):
            candidate = (start_base + timedelta(minutes=minutes * i)).replace(second=0, microsecond=0)

            # Skip slots earlier than right now if booking for today
            if candidate < now_local:
                continue

            if candidate not in taken_starts:
                start_dt = candidate
                break

        if start_dt is None:
            return f"لا توجد مواعيد متاحة في {date}."

        end_dt = start_dt + timedelta(minutes=minutes)

        event = {
            'summary': f'موعد مع {mobile}',
            'start': {'dateTime': start_dt.isoformat(), 'timeZone': tz_name},
            'end': {'dateTime': end_dt.isoformat(), 'timeZone': tz_name},
        }

        service.events().insert(calendarId='primary', body=event).execute()

        weekday_name = get_arabic_weekday(start_dt)
        return f"تم حجز موعد للعميل {mobile}، يوم {weekday_name} بتاريخ {date} الساعة {start_dt.strftime('%H:%M')}."

    except Exception as e:
        return f"تعذر حجز الموعد : {e}"


def get_appointments(SCOPES: List[str], CREDENTIALS_FILE: str, TOKEN_FILE: str, mobile: str) -> str:
    try:
        if not mobile:
            return "نحتاج رقم التعريف لعرض المواعيد."

        service = get_calendar_service(SCOPES, CREDENTIALS_FILE, TOKEN_FILE)

        now = datetime.now(timezone.utc).isoformat().replace("+00:00", "Z")

        events = service.events().list(
            calendarId='primary',
            timeMin=now,
            singleEvents=True,
            orderBy='startTime'
        ).execute().get('items', [])

        user_events = [e for e in events if mobile in e.get("summary", "")]
        if not user_events:
            return "لا توجد مواعيد حالية لهذا الرقم."

        response = "مواعيدك القادمة:\n"
        for e in user_events:
            start = e['start'].get('dateTime') or e['start'].get('date')
            dt = datetime.fromisoformat(start)
            arabic_day = get_arabic_weekday(dt)
            response += f"- {arabic_day} {dt.strftime('%Y-%m-%d')} الساعة {dt.strftime('%H:%M')}\n"

        return response.strip()

    except Exception as e:
        return f"تعذر جلب المواعيد: {e}"


def cancel_appointment(
    SCOPES: List[str], 
    CREDENTIALS_FILE: str, 
    TOKEN_FILE: str, 
    date: str, 
    mobile: str,
    tz_name: str = "Africa/Tunis"
) -> str:
    try:
        if not mobile:
            return "نحتاج رقم مُعرّف لإلغاء الموعد."

        try:
            base_date = datetime.strptime(date, "%Y-%m-%d").date()
        except ValueError:
            return "تنسيق التاريخ غير صحيح. استخدم YYYY-MM-DD."

        service = get_calendar_service(SCOPES, CREDENTIALS_FILE, TOKEN_FILE)

        tz = pytz.timezone(tz_name)
        day_start_local = tz.localize(datetime.combine(base_date, datetime.min.time()))
        day_end_local = day_start_local + timedelta(days=1)

        day_start = day_start_local.astimezone(pytz.utc).isoformat().replace("+00:00", "Z")
        day_end = day_end_local.astimezone(pytz.utc).isoformat().replace("+00:00", "Z")

        events = service.events().list(
            calendarId='primary',
            timeMin=day_start,
            timeMax=day_end,
            singleEvents=True,
            orderBy='startTime'
        ).execute().get('items', [])

        matching_events = [e for e in events if mobile in e.get("summary", "")]
        if not matching_events:
            return f"لا يوجد موعد لهذا الرقم في {date}."

        event = matching_events[0]
        start_str = event['start'].get('dateTime') or event['start'].get('date')
        event_time_obj = datetime.fromisoformat(start_str).astimezone(tz)

        service.events().delete(calendarId='primary', eventId=event['id']).execute()

        return f"تم إلغاء الموعد بتاريخ {date} الساعة {event_time_obj.strftime('%H:%M')}."

    except Exception as e:
        return f"حدث خطأ أثناء محاولة الإلغاء: {e}"


if __name__ == "__main__":
    BASE_DIR = os.path.dirname(os.path.abspath(__file__))
    SCOPES_LIST = ["https://www.googleapis.com/auth/calendar"]
    CRED_FILE = os.path.join(BASE_DIR, "credentials.json")
    TOK_FILE = os.path.join(BASE_DIR, "token.json")

    m1 = "1111"
    m2 = "2222"
    local_tz = "Africa/Tunis"

    test_date = (datetime.now() + timedelta(days=1)).strftime("%Y-%m-%d")

    print(schedule_appointment(SCOPES_LIST, CRED_FILE, TOK_FILE, test_date, m1, tz_name=local_tz))
    print(schedule_appointment(SCOPES_LIST, CRED_FILE, TOK_FILE, test_date, m2, tz_name=local_tz))
    print(get_appointments(SCOPES_LIST, CRED_FILE, TOK_FILE, m1))
    print(cancel_appointment(SCOPES_LIST, CRED_FILE, TOK_FILE, test_date, m2, tz_name=local_tz))
    print(get_appointments(SCOPES_LIST, CRED_FILE, TOK_FILE, m1))
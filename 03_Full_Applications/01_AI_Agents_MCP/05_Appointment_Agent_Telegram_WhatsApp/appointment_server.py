import os
import re
import sys
from datetime import date
from typing import Optional

from dotenv import load_dotenv
from mcp.server.fastmcp import FastMCP
from ollama import chat

import calendar_tools.calendar_functions as cal
import db_tools.db_functions as db
import email_tools.email_functions as em

sys.stdout.reconfigure(encoding="utf-8")
load_dotenv()

mcp = FastMCP("appointment")

# Directory helper to resolve relative path execution issues
BASE_DIR = os.path.dirname(os.path.abspath(__file__))


# --- Resources ---
@mcp.resource("resource://calendar_scopes_resource")
def calendar_scopes_resource():
    return ["https://www.googleapis.com/auth/calendar"]


@mcp.resource("resource://credentials_file_resource")
def credentials_file_resource():
    return os.path.join(BASE_DIR, "credentials.json")


@mcp.resource("resource://token_file_resource")
def token_file_resource():
    return os.path.join(BASE_DIR, "token.json")


@mcp.resource("resource://smtp_settings_resource")
def smtp_settings_resource():
    return {
        "from": os.getenv("EMAIL_FROM", "you@example.com"),
        "password": os.getenv("EMAIL_PASSWORD", "app-password"),
        "server": os.getenv("SMTP_SERVER", "smtp.gmail.com"),
        "port": int(os.getenv("SMTP_PORT", 587)),
    }


@mcp.resource("resource://pg_config_resource")
def pg_config_resource():
    return {
        "user": os.getenv("DB_USER"),
        "password": os.getenv("DB_PASSWORD"),
        "host": os.getenv("DB_HOST", "localhost"),
        "port": int(os.getenv("DB_PORT", 5432)),
    }


@mcp.resource("resource://db_name_resource")
def db_name_resource():
    return os.getenv("DB_NAME")


@mcp.resource("resource://db_config_resource")
def db_config_resource():
    config = pg_config_resource().copy()
    config["dbname"] = db_name_resource()
    return config


@mcp.resource("resource://timezone_resource")
def timezone_resource():
    return os.getenv("TIMEZONE", "Asia/Riyadh")


@mcp.resource("resource://working_hours_resource")
def working_hours_resource():
    return {
        "start_hour": int(os.getenv("START_HOUR", 10)),
        "end_hour": int(os.getenv("END_HOUR", 17)),
        "interval_minutes": int(os.getenv("INTERVAL_MINUTES", 30)),
    }


@mcp.resource("resource://custom_data_snippet_resource")
def custom_data_snippet_resource():
    file_path = os.path.join(BASE_DIR, "center_data.txt")
    if not os.path.exists(file_path):
        return ""
    with open(file_path, encoding="utf-8") as f:
        return f.read()


@mcp.resource("resource://telegram_token_resource")
def telegram_token_resource():
    return os.getenv("TELEGRAM_TOKEN", "")


# --- Helper Functions ---
def extract_email_from_text(text: str) -> str:
    matches = re.findall(
        r"[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+", text or ""
    )
    return matches[0].strip() if matches else ""


def safely_parse_db_email(db_result: any) -> str:
    """Extracts a string safely whether db returns a str, tuple, or None."""
    if not db_result:
        return ""
    if isinstance(db_result, (tuple, list)):
        return str(db_result[0]).strip() if db_result[0] else ""
    return str(db_result).strip()


# --- Tools ---
@mcp.tool(name="schedule_appointment_tool")
def schedule_appointment_tool(
    mobile: str,
    date: str,
    email: Optional[str] = None,
    user_input: Optional[str] = None,
) -> str:
    try:
        if not mobile or not str(mobile).strip():
            return "الرجاء تزويدنا برقم الجوال لإتمام الحجز."

        DB_CONFIG = db_config_resource()
        target_email = (email or "").strip()
        extracted = extract_email_from_text(user_input)

        if not target_email:
            db_email = safely_parse_db_email(
                db.get_email(mobile, DB_CONFIG)
            )
            target_email = db_email if db_email else extracted

        if target_email:
            db.add_or_update_customer(mobile, target_email, DB_CONFIG)

        answer = cal.schedule_appointment(
            mobile=mobile,
            date=date,
            tz_name=timezone_resource(),
            SCOPES=calendar_scopes_resource(),
            CREDENTIALS_FILE=credentials_file_resource(),
            TOKEN_FILE=token_file_resource(),
            start_hour=working_hours_resource()["start_hour"],
            end_hour=working_hours_resource()["end_hour"],
            minutes=working_hours_resource()["interval_minutes"],
        )

        if target_email and extracted:
            answer += f"\nتم تحديث بياناتك:\nالبريد: {target_email}"

        if target_email:
            try:
                em.send_email(
                    to=target_email,
                    subject="تأكيد حجز موعد",
                    body=answer,
                    settings=smtp_settings_resource(),
                )
            except Exception as mail_err:
                answer += f"\n(ملاحظة: تعذّر إرسال بريد التأكيد: {mail_err})"

        db.log_conversation(mobile, "user", user_input or "", DB_CONFIG)
        db.log_conversation(mobile, "assistant", answer, DB_CONFIG)
        return answer

    except Exception as e:
        print(f"فشل في حجز موعد: {e}", file=sys.stderr)
        return "حدث خطأ أثناء محاولة حجز الموعد."


@mcp.tool(name="get_appointments_tool")
def get_appointments_tool(
    mobile: str, user_input: Optional[str] = None
) -> str:
    try:
        if not mobile or not str(mobile).strip():
            return "نحتاج رقم التعريف (رقم الجوال) لعرض المواعيد."

        answer = cal.get_appointments(
            mobile=mobile,
            SCOPES=calendar_scopes_resource(),
            CREDENTIALS_FILE=credentials_file_resource(),
            TOKEN_FILE=token_file_resource(),
        )

        DB_CONFIG = db_config_resource()
        extracted_email = extract_email_from_text(user_input or "")

        if extracted_email:
            db.add_or_update_customer(mobile, extracted_email, DB_CONFIG)
            answer += f"\nتم تحديث بياناتك:\nالبريد: {extracted_email}"

        db.log_conversation(mobile, "user", user_input or "", DB_CONFIG)
        db.log_conversation(mobile, "assistant", answer, DB_CONFIG)
        return answer

    except Exception as e:
        print(f"فشل في عرض المواعيد: {e}", file=sys.stderr)
        return "حدث خطأ أثناء استرجاع المواعيد."


@mcp.tool(name="cancel_appointment_tool")
def cancel_appointment_tool(
    mobile: str, date: str, user_input: Optional[str] = None
) -> str:
    try:
        if not mobile or not str(mobile).strip():
            return "نحتاج رقم العميل لإلغاء الموعد."

        answer = cal.cancel_appointment(
            mobile=mobile,
            date=date,
            SCOPES=calendar_scopes_resource(),
            CREDENTIALS_FILE=credentials_file_resource(),
            TOKEN_FILE=token_file_resource(),
        )

        DB_CONFIG = db_config_resource()
        extracted_email = extract_email_from_text(user_input or "")

        if extracted_email:
            db.add_or_update_customer(mobile, extracted_email, DB_CONFIG)
            answer += f"\nتم تحديث بياناتك:\nالبريد: {extracted_email}"

        db.log_conversation(mobile, "user", user_input or "", DB_CONFIG)
        db.log_conversation(mobile, "assistant", answer, DB_CONFIG)
        return answer

    except Exception as e:
        print(f"فشل في إلغاء موعد: {e}", file=sys.stderr)
        return "حدث خطأ أثناء إلغاء الموعد."


@mcp.tool(name="default_response")
def default_response(
    user_input: str, mobile: Optional[str] = None
) -> str:
    try:
        DB_CONFIG = db_config_resource()
        msg = "مرحبًا بك في مركزنا! هذا البوت مخصص لحجز أو إلغاء أو عرض المواعيد."

        extracted_email = extract_email_from_text(user_input)

        if mobile and extracted_email:
            db.add_or_update_customer(mobile, extracted_email, DB_CONFIG)
            msg += f"\n تم تحديث بياناتك:\n البريد: {extracted_email}"

        my_data = custom_data_snippet_resource()
        prompt = f"""
        استخدم المعلومات التالية لإجابة المستخدم إذا كان سؤاله من ضمن هذه المعلومات:
        -------------------
        {my_data}
        -------------------
        وذلك باللغة العربية فقط
        وبشكل مختصر جدا 
        لا تخترع معلومات من عندك
        لا تطلب اسم العميل
        لا تستخدم إيموجي في إجاباتك
        إذا كان المستخدم يقوم بالتحية أو السلام فرد عليه بتحية أو سلام باللغة العربية
        "{user_input}"
        """

        llm_response = chat(
            model="gemma2",
            messages=[{"role": "system", "content": prompt}],
        )

        raw_text = llm_response["message"]["content"].strip()
        msg += f"\n\n{raw_text}"

        if mobile:
            missing_email = db.check_missing_email(mobile, DB_CONFIG)
            if not extracted_email and missing_email:
                msg += "\nيمكنكم تزويدنا ببريدك الإلكتروني لتأكيد أي حجز عليه."

            db.log_conversation(mobile, "user", user_input, DB_CONFIG)
            db.log_conversation(mobile, "assistant", msg, DB_CONFIG)

        return msg

    except Exception as e:
        print(f"فشل في الإجابة عن سؤال العميل: {e}", file=sys.stderr)
        return "أهلاً بك! كيف يمكنني مساعدتك اليوم؟"


# --- Prompt ---
@mcp.prompt(
    name="appointment_prompt",
    description="تصنيف رسالة المستخدم واستدعاء الأداة المناسبة بصيغة JSON.",
)
def appointment_prompt(
    user_input: str, today: str = str(date.today())
):
    return f"""
    أنت مساعد ذكي باللغة العربية، مهمتك فهم رسالة المستخدم وتصنيفها بدقة لاستدعاء الأداة المناسبة.
    من بين أربعة أدوات متاحة فقط
    علما أن تاريخ اليوم: {today}

    الأوامر المتاحة:
    **حجز موعد** 
    في حال طلب المستخدم حجز موعد في تاريخ محدد 
    الأداة: `schedule_appointment_tool`  
    المتطلبات:
    - `date`: تاريخ الموعد بصيغة YYYY-MM-DD  
    - `mobile`: رقم الجوال  
    اختياري:
    - `email`: البريد الإلكتروني  

    **إلغاء موعد**  
    في حال طلب المستخدم حذف أو الغاء موعد من تاريخ محدد
    الأداة: `cancel_appointment_tool`  
    المتطلبات:
    - `date`: تاريخ الموعد بصيغة YYYY-MM-DD  
    - `mobile`: رقم الجوال  

    **عرض المواعيد القادمة**  
    في حال طلب المستخدم عرض مواعيده المحجوزة القادمة
    الأداة: `get_appointments_tool`  
    - `mobile`: رقم الجوال  

    **رسائل غير متعلقة بالمواعيد**  
    في حال أدخل المستخدم نص أو سؤال لا علاقة له بالمواعيد والحجوزات
    الأداة: `default_response`  
    المتطلبات:
    - `user_input`: نص رسالة المستخدم  

    رسالة المستخدم:
    {user_input}

    المخرجات المتوقعة:
    أرجع كائن JSON واحد فقط بالصيغة:
    {{
      "tool": "<tool_name>",
      "args": {{ ... }}
    }}
    """


if __name__ == "__main__":
    PG_BASE_CONFIG = pg_config_resource()
    DB_CONFIG = db_config_resource()
    DB_NAME = db_name_resource()

    db.create_database(DB_NAME, PG_BASE_CONFIG)
    db.create_tables(DB_CONFIG)

    mcp.run(transport="stdio")
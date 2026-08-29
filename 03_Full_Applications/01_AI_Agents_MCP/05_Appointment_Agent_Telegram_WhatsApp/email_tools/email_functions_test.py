import os
from dotenv import load_dotenv
import email_functions as em

load_dotenv()

smtp_settings = {
    "from": os.getenv("EMAIL_FROM", "you@example.com"),
    "password": os.getenv("EMAIL_PASSWORD", "app-password"),
    "server": os.getenv("SMTP_SERVER", "smtp.gmail.com"),
    "port": int(os.getenv("SMTP_PORT", 587)),
}

if __name__ == "__main__":
    status = em.send_email(
        to="test@gmail.com",
        subject="اختبار",
        body="هذا اختبار إرسال بريد الكتروني من بايثون",
        settings=smtp_settings,
    )

    print(status)
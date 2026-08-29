<div dir="rtl">

# إعداد البيئة الافتراضية للمشروع

* إنشاء البيئة الافتراضية باستخدام الأمر:

<h6 dir="ltr">

`uv venv`

</h6>

* تفعيل البيئة الافتراضية نفذ الأمر:

<h6 dir="ltr">

`.venv\Scripts\activate`

</h6>

* تنزيل المكتبات اللازمة لتشغيل المشروع بعد تفعيل البيئة:

<h6 dir="ltr">

`uv sync`

</h6>

* تنزيل أحد نماذج Ollama نفذ الأمر:

<h6 dir="ltr">

`ollama pull llama3`

</h6>

* في ملف `env` حدد إعدادات قاعدة البيانات PostegreSQL الخاصة بك:

<h6 dir="ltr">

`DB_USER=postgres`
`DB_PASSWORD=`
`DB_HOST=localhost`
`DB_PORT=5432`
`DB_NAME=`

</h6>

* في ملف `env` حدد إعدادات  البريد الإلكتروني الخاصة بك:

<h6 dir="ltr">

`EMAIL_FROM=`
`EMAIL_PASSWORD=`
`SMTP_SERVER=smtp.gmail.com`
`SMTP_PORT=587`

</h6>

* في ملف `env` حدد مفتاح تلغرام الخاص بتطبيقك:

<h6 dir="ltr">

`TELEGRAM_TOKEN=`

</h6>

* يجب إضافة `credentials.json` الذي تحصل عليه من Google Calender إلى المسار الرئيسي للمشروع

* لشغيل عميل Telegram:

<h6 dir="ltr">

`uv run appointment_Telegram_client.py`

</h6>

* لشغيل عميل WhatsApp:

<h6 dir="ltr">

`uv run appointment_Whatsapp_client.py`

</h6>

</div>
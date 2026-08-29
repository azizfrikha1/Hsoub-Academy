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

*  في ملف `env` حدد مفتاح الوصول إلى النموذج GPT:

<h6 dir="ltr">

`DB_USER=postgres`
`DB_PASSWORD=`
`DB_HOST=localhost`
`DB_PORT=5432`
`DB_NAME=`

</h6>

* في ملف `env` حدد مفتاح تلغرام الخاص بتطبيقك:

<h6 dir="ltr">

`TELEGRAM_TOKEN=`

</h6>

* لتشغيل المشروع نفذ الأمر:

<h6 dir="ltr">

`uv run .\ecommerce_Telegram_client.py`

</h6>

</div>
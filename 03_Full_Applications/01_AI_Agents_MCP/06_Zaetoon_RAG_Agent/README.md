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

* في ملف `env` حدد مفتاح الوصول إلى النموذج GPT:

<h6 dir="ltr">

`GPT_KEY=`

</h6>

* في ملف `env` حدد مفتاح الوصول إلى منصة زيتون:

<h6 dir="ltr">

`ZEYTOON_TOKEN=`

</h6>

* في ملف `env` حدد معرف الوكيل الذكي الخاص بك:

<h6 dir="ltr">

`ai_agent_id=`

</h6>

* شغل خادم MCP بتنفيذ الأمر:

<h6 dir="ltr">

`uv run zaetoon_server.py`

</h6>

* شغل عميل MCP بتنفيذ الأمر:

<h6 dir="ltr">

`uv run zaetoon_client.py`

</h6>

</div>
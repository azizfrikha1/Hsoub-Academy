
<div  dir="rtl">

  
# دمج تقنيات الذكاء الاصطناعي مع متجر إلكتروني

### الشيفرة المصدرية لدمج تقنيات الذكاء الاصطناعي مع متجر إلكتروني من دورة "الذكاء الاصطناعي" المقدمة من أكاديمية حسوب

<a  href="https://academy.hsoub.com/learn/artificial-intelligence/">دورة الذكاء الاصطناعي</a>

# خطوات تشغيل المشروع

* نحتاج لتنزيل البرنامج `XAMPP` لتشغيل المشروع على خادم محلي

* نضع المجلد `ecommerce` بداخل المجلد `htdocs` الموجود بداخل مسار البرنامج `XAMPP`

* نفتح البرنامج `XAMPP` ونشغل خادم `apache` وقاعدة البيانات `MySQL`

* نفك الضغط عن قاعدة البيانات الموجودة في الملف wp-ecommerce.zip

* لرفع قاعدة البيانات على الخادم المحلي نُنشئ قاعدة بيانات بالاسم wp-ecommerce ونفتح موجه الأوامر وننفذ الأمر

<h6  dir="ltr">

`mysql -u root -p -h localhost -D wp-ecommerce < wp-ecommerce.sql`

</h6>

  * الآن لتشغيل خادم فلاسك سنتجه إلى المجلد `flask_api` وننزل متطلبات المشروع
<h6  dir="ltr">  

`.pipenv install -r requirements.txt`

</h6>
* نفتح موجه الأوامر في مسار المجلد `flask_api` ونفعل البيئة الافتراضية بتنفيذ الأمر

<h6  dir="ltr">

`pipenv shell`

</h6>

* لتشغيل خادم فلاسك ننفذ الأمر

<h6  dir="ltr">

`flask --app store_api run`

</h6>

* الآن أصبح المشروع جاهز للتشغيل، نفتح المتصفح ونكتب الرابط

<h6  dir="ltr">

`localhost/ecommerce/`

</h6>

* لفتح لوحة تحكم المتجر نتجه إلى الرابط

<h6  dir="ltr">

`localhost/ecommerce/wp-admin`

`e-mail: admin@admin.com`

`password: Admin123456?`

</h6>

* للتوجه لصفحة تقنيات الذكاء الاصطناعي

<h6  dir="ltr">

`localhost/ecommerce/manger`

</h6>

</div>

<div dir="rtl">

# تطبيق لتحليل الصور باستخدام الشبكات العصبية

### الشيفرة المصدرية لتطبيق تحليل الصور باستخدام الشبكات العصبية من دورة "الذكاء الاصطناعي" المقدمة من أكاديمية حسوب

<a  href="https://academy.hsoub.com/learn/artificial-intelligence/">دورة الذكاء الاصطناعي</a>

## كيفية تشغيل المشروع

<ol>

<li>نذهب إلى مجلد المشروع</li>
<li>نُنشئ البيئة الافتراضية وننزل المكتبات الخاصة بالمشروع</li>
<code>pipenv install -r requirements.txt</code>
<li>في حال لم تكن pipenv لدينا يمكن تنزيلها</li>
<code>pip install pipenv</code>
<li>في حال لم تعمل بسبب أنه لم يتعرف عليها رغم وجودها يمكن كتابة</li>
<code>python -m pipenv install -r requirements.txt</code>
<li>ندخل إلى البيئة الافتراضية عن طريق كتابة</li>
<code>pipenv shell</code>
<li>في حال لم تعمل بسبب أنه لم يتعرف عليها رغم وجودها يمكن كتابة</li>
<code>python -m pipenv shell</code>
<li>يمكن تشغيل التطبيق</li>
<li><code>cd food_app</code></li>
<li><code>python manage.py runserver</code></li>

<li>نشغل الخادم الخاص بال api عن طريق فتح نافذة سطر أوامر جديدة و القيام بالخطوات التالية:</li>

 1. نذهب إلى مجلد المشروع
 2. ندحل إلى البيئة الافتراضية عن طريق كتابة
 <code>pipenv shell</code>
 3. نتوجه إلى المجلد ai_server
 4. نشغل الخادم (قد تأخذ هذه العملية بعض الوقت كونها تشمل تحميل نماذج الذكاء الاصطناعي إلى الذاكرة):
 <code dir="ltr">flask run</code>

</ol>
</div>
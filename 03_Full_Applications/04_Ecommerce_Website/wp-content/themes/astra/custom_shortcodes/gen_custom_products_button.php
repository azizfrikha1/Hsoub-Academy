<?php
function gen_custom_products_button()
{
    $output = "";
    if (isset($_POST["update"])) {
        // جلب مسار الطلب
        $API_PATH = get_flask_api_url("genCustomProducts");
        // التقاط الاخطاء
        try {
            // ارسال طلب post لتشغيل عملية توليد القواعد
            $response = wp_remote_post(
                $API_PATH,
                array(
                    'method' => 'POST',
                    'headers' => array(),
                )
            );
            // ناخذ الرد بشكل نص
            $body = $response['body'];
            // تحول النص الى مصفوفة
            $responseData = json_decode($body, true);

            if ($responseData['ok']) {
                $output .= '<br>
                    <p style="color:green;">جاري تحديث البيانات</p>
                    <p">يرجى اعادة تحميل الصفحة بعد قليل لتحديث الحالة</p>';
            } else {
                $output .= '<br>
                    <span style="color:red;">حدث خطأ ' . $responseData['msg'] . '</span>';
            }

        } catch (\Throwable $th) {
            // يحصل خطأ اذا كان خادم api متوقف او يرسل رد غير صحيح
            $output .= '<br>
                <span style="color:red;">حدث خطأ يرجى التأكد من الخادم' . $th . '</span>';
        }

         // منع اعادة ارسال الفورم بعد عمل ريفرش للصفحة
         $output .= '<script>
         if ( window.history.replaceState ) {
             window.history.replaceState( null, null, window.location.href );
         }
         </script>';
    }

    // جلب البيانات من رابط api
    // جلب الحالة
    $API_PATH = get_flask_api_url("getState");

    try {

        $response = wp_remote_get($API_PATH);

        $body = $response['body'];
        $responseData = json_decode($body, true);
        $gen_custom_products_run = ($responseData != null) ? $responseData["gen_custom_products_run"] : false;

        if (!$gen_custom_products_run) {
            $button = '<span>انقر على الزر ادناه لتحديث بيانات توصيات الشراء بالنسبة للمنتجات المترابطة</span><br><button name="update" type="submit"  class="wpforms-submit"  value="submit">تحديث</button>';
        } else {
            $button = '<div class="loader"></div>
            </button>
            <style>
            .loader {
                border: 5px solid #f3f3f3;
                -webkit-animation: spin 1s linear infinite;
                animation: spin 1s linear infinite;
                border-top: 5px solid #555;
                border-radius: 50%;
                width: 50px;
                height: 50px;
            }
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        </style>
        ';
        }
    } catch (\Throwable $th) {
        $button = 'حدث خطأ غير متوقع، تأكيد من تشغيل وتكون خادم flask api';
    }
    $output .= '
    <form method="post">
        <b>تحديث البيانات المترابطة</b><br>' . $button . '
    </form>
    ';

    return $output;
}

add_shortcode('gen_custom_products', 'gen_custom_products_button');

?>
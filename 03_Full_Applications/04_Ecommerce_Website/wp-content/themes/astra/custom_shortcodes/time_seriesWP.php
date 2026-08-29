<?php
function time_seriesWP()
{
    $output = "";
    if (isset($_POST["timeseriesUpdate"])) {
        $API_PATH = get_flask_api_url("time_seriesWP");
        
        try {
            $response = wp_remote_post(
                $API_PATH,
                array(
                    'method' => 'POST',
                    'headers' => array(),
                    'timeout' => 45,
                )
            );
            $body = $response['body'];
            $responseData = json_decode($body, true);
            
            if ($responseData['ok']) {
                $output .= '<br>
                    <p style="color:green;">جاري تحديث البيانات</p>
                    <p">يرجى إعادة تحميل الصفحة بعد مدة لتحديث الحالة</p>';
            } else {
                $output .= '<br>' . 'حدث خطأ' . $responseData['msg'];
            }
        } catch (\Throwable $th) {
            $output .= '<br>' . 'حدث خطأ';
        }

        // منع اعادة ارسال الفورم بعد عمل تحديث للصفحة
        $output .= '<script>
                        if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, window.location.href );
                        }
                    </script>';
    }

    // جلب البيانات من رابط api
    $API_PATH = get_flask_api_url("draw_forecast");
    try {

        $img_src = wp_remote_post($API_PATH)['body'];
        $img = '<img width="500" height="600" src="' . $img_src . '">';
        
        // جلب الحالة
        $API_PATH = get_flask_api_url("getState");
        $response = wp_remote_get($API_PATH);

        $body = $response['body'];
        $responseData = json_decode($body, true);
        $time_series_products_run = ($responseData != null) ? $responseData["time_series_products_run"] : false;

        if (!$time_series_products_run) {
            $button = '<span>انقر على الزر ادناه لتحديث نمودج التوقع</span><br><button name="timeseriesUpdate" type="submit"  class="wpforms-submit"  value="submit">تحديث</button>';
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
        $img = '<br>حدث خطأ في تحميل الصورة !';
        $button = 'حدث خطأ غير متوقع، تأكد من تشغيل الخادم';
    }


    $output .= '
                <div>
                    <b>توقع المبيعات المستقبلية</b><br>
                    <span>مخطط المبيعات المستقبلية</span>
                    ' . $img . '
                </div><br>
                <form method="post">
                    ' . $button . '
                </form>
                <hr>
    ';

    return $output;
}

add_shortcode('time_seriesWP_update', 'time_seriesWP');

?>
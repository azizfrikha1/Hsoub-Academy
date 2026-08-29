<?php
function classificationWP()
{
    // الغاء مهلة الانتظار
    set_time_limit(0);

    $output = "";

    if (isset($_POST["classificationUpdate"])) {
        $API_PATH = get_flask_api_url("classificationWP");

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
                #print_r($response);
                $responseData = json_decode($body, true);
                if ($responseData['ok']) {
                    $output .= '<br>
                    <b style="color:green;">تمت عملية تحديث البيانات بنجاح</b>';
                } else {
                    $output .= '<br><span style="color:red;">حدث خطأ ' . $responseData['msg'] . '</span>';
                }

            } catch (\Throwable $th) {
                $output .= '<br><span style="color:red;">حدث خطأ </span>';
            }
        }

            $button = '<button name="classificationUpdate" type="submit"  class="wpforms-submit"  value="submit">تحديث</button>';

            // جلب البيانات من رابط api
            $output .= '<form method="post">
                            <b>تحديث نمودج التصنيف</b><br>
                            <span>انقر على الزر ادناه لاعادة توليد بيانات توصيات الشراء بالنسبة  لمواصفات الزبون</span><br> '.$button.'
                        </form>';

    return $output;
}

add_shortcode('classification', 'classificationWP');

?>
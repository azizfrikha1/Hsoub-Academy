<?php
function find_products_for_customer()
{
    // اذا كان العضو زائر عدم عرض القسم
    if (!is_user_logged_in())
        return "";
    // استدعاء الـ API أو أي منطق أخرى للحصول على قائمة المنتجات المناسبة
    // جلب معرف العميل
    $user_id = get_current_user_id();
    // تعريف رابط مسار api لارسال طلب اليه
    $API_PATH = get_flask_api_url("get_products_for_user");
    // اضافة معرف العميل الى الطلب
    $API_PATH .= "?user_id=" . $user_id . "&limit=3";

    try {
        $response = wp_remote_get($API_PATH);

        $body = $response['body'];
        
        $responseData = json_decode($body, true);

        if ($responseData['ok']) {
            
            $product_ids = implode(",", $responseData["products_list"]);
            $output = '<section class="related products">
                        <h2>منتجات مختارة لك</h2>
                        ' . do_shortcode('[products ids="' . $product_ids . '"]') . '
                       </section>';
        } else {
            $output = '';
            print("no element". $responseData);
        }
    } catch (\Throwable $th) {
        // اذا حدث خطأ بسبب ايقاف تشغيل خادم flask
        $output = '';
        print("error". $th);
    }

    // طباعة المنتجات مع المحافظة على تصميم القالب
    return $output;
}

add_shortcode('find_products_for_customer', 'find_products_for_customer');
?>
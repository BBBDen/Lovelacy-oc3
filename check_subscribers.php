<?php
require "config.php";
function do_curl_request($url, $params = []) {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR,  DIR_LOGS . '/apicookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, DIR_LOGS . '/apicookie.txt');

    $params_string = '';
    if (is_array($params) && count($params)) {
        foreach($params as $key=>$value) {
            $params_string .= $key.'='.$value.'&';
        }
        rtrim($params_string, '&');

        curl_setopt($ch,CURLOPT_POST, count($params));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $params_string);
    }

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}

$url = HTTPS_SERVER . 'index.php?route=api/login';
$fields = [
    'username' => API_USERNAME,
    'key' => API_KEY,
];
$json = do_curl_request($url, $fields);
$data = @json_decode($json, true);
if (isset($data['error'])) {
    $msg = "";
    foreach ( $data['error']as $err) {
        $msg .= $err . " ";
    }
    print_r("Error: " . $msg);
} else {

    if (isset($data['api_token'])) {
        $result = @json_decode(do_curl_request(HTTPS_SERVER . 'index.php?route=api/subscribers&api_token=' . $data['api_token']), true);
        $msg = "================================================\n";
        $msg .= 'Date: ' . date('Y-m-d H:i:m') . "\n";
        $msg .= "************************************************\n";
        foreach ($result['subs_info'] as $item) {
            $msg .= "ID: " . $item['card_subscribe_info_id'] . ", Status: " . $item['pay_status'] . ", SBS_ID: " . $item['bepayed_sbs_id'] . "\n";
        }
        $msg .= "\n================================================\n";
        print_r($msg);
    } else {
        print_r("Error: Ошибка API Token");
    }
}



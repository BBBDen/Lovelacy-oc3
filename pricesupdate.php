<?php
$start = microtime(true);
$offsetcount = 0;
$responsestatus = true;
$moyskladarr = [];
while ($responsestatus == true) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://online.moysklad.ru/api/remap/1.1/entity/assortment?expand=product,productFolder,product.productFolder,supplier,product.supplier,uom,product.uom&limit=100&offset=' . $offsetcount,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_USERPWD => "spasatelkotikov@lovelace:cP7TrCrqTY"
    ));


    $response = curl_exec($curl);
    if (count(json_decode($response, true)['rows']) > 0) {


        array_push($moyskladarr, json_decode($response, true));

        $offsetcount += 100;
        curl_close($curl);

    } elseif (count(json_decode($response, true)['rows']) == 0) {
        $responsestatus = false;
        curl_close($curl);

    }


}
$array = [];
$count = 0;

for ($l = 0; $l <= count($moyskladarr); $l++) {
    for ($i = 0; $i <= count($moyskladarr[$l]['rows']); $i++) {

        for ($k = 0; $k <= 1; $k++) {

            if ($moyskladarr[$l]['rows'][$i]['product'] <> 0) {
                if ($moyskladarr[$l]['rows'][$i]['salePrices'][$k]['priceType'] == 'Цена продажи BYN') {
                    $newarr = array(

                        "xmlId" => $moyskladarr[$l]['rows'][$i]['product']['externalCode'] . '#' . $moyskladarr[$l]['rows'][$i]['externalCode'],
                        "site" => "lovelaceby",
                        "prices" => array(array("code" => "v-byn",
                            "price" => (float)$moyskladarr[$l]['rows'][$i]['salePrices'][$k]['value'] / 100
                        ))


                    );
                    array_push($array, $newarr);
                }

                if ($moyskladarr[$l]['rows'][$i]['salePrices'][$k]['priceType'] == 'Цена продажи RUB') {
                    $newarr = array(
                        "xmlId" => $moyskladarr[$l]['rows'][$i]['product']['externalCode'] . '#' . $moyskladarr[$l]['rows'][$i]['externalCode'],
                        "site" => "lovelaceby",
                        "prices" => array(array("code" => "v-rub",
                            "price" => (float)$moyskladarr[$l]['rows'][$i]['salePrices'][$k]['value'] / 100
                        ))


                    );
                    array_push($array, $newarr);
                }


            } elseif ($moyskladarr[$l]['rows'][$i]['product'] == 0) {
                if ($moyskladarr[$l]['rows'][$i]['salePrices'][$k]['priceType'] == 'Цена продажи BYN') {
                    $newarr = array(

                        "xmlId" => $moyskladarr[$l]['rows'][$i]['externalCode'],
                        "site" => "lovelaceby",
                        "prices" => array(array("code" => "v-byn",
                            "price" => (float)$moyskladarr[$l]['rows'][$i]['salePrices'][$k]['value'] / 100
                        ))


                    );
                    array_push($array, $newarr);
                }

                if ($moyskladarr[$l]['rows'][$i]['salePrices'][$k]['priceType'] == 'Цена продажи RUB') {
                    $newarr = array(
                        "xmlId" => $moyskladarr[$l]['rows'][$i]['externalCode'],
                        "site" => "lovelaceby",
                        "prices" => array(array("code" => "v-rub",
                            "price" => (float)$moyskladarr[$l]['rows'][$i]['salePrices'][$k]['value'] / 100
                        ))


                    );
                    array_push($array, $newarr);
                }


            }


        }

    }

}


$curlarray = [];
$offset = 0;

for ($i = 0; $i <= count($array); $i += 250) {
    array_push($curlarray, array_slice($array, $offset, 249));
    $offset += 250;
}

var_dump($curlarray);
//for ($i = 0; $i <= count($curlarray) - 1; $i++) {
//    $curl = curl_init();
//    curl_setopt_array($curl, array(
//        CURLOPT_URL => 'https://lovelaceby.retailcrm.ru/api/v5/store/prices/upload?apiKey=EDc6XtaRdtNArVbpD8hx9ocxh1YvCHsP',
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => '',
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 0,
//        CURLOPT_FOLLOWLOCATION => true,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => 'POST',
//        CURLOPT_POSTFIELDS => array('prices' => json_encode($curlarray[$i]))
//
//    ));
//    $response = curl_exec($curl);
//
//    echo $response . "\n";
//    curl_close($curl);
//}

echo 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.';







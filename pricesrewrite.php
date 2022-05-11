<?php
if (file_exists('catalogRUB.xml') and file_exists('catalogMoySklad.xml')) {
    $catalogRUB = json_encode(simplexml_load_file('catalogRUB.xml'));
    $catalogMoySklad = json_encode(simplexml_load_file('catalogMoySklad.xml'));

    $catalogRUB = json_decode($catalogRUB, true);
    $catalogMoySklad = json_decode($catalogMoySklad, true);


    $newarr = [];

//    var_dump($catalogRUB['shop']['offers']['offer']);
    foreach ($catalogMoySklad as $row) {

        for ($i = 1; $i <= count($row['offers']['offer']); $i++) {

            $arr = array('xmlID' => $row['offers']['offer'][$i]['xmlId'], 'price' => $row['offers']['offer'][$i]['price']);
            array_push($newarr, $arr);
        }
    }




    $count = count($catalogRUB['shop']['offers']['offer']);

    for ($i = 1; $i <= $count; $i++) {
        foreach ($newarr as $rowRUB) {

            if ($catalogRUB['shop']['offers']['offer'][$i]['xmlId'] == $rowRUB['xmlID']) {

                $catalogRUB['shop']['offers']['offer'][$i]['price'] = $rowRUB['price'];


            }
            else
            {
                $catalogRUB['shop']['offers']['offer'][$i]['price'] = '0.00';
            }

        }

    }


//    foreach($catalogRUB as $row) {
//     echo '<pre>';
//    print_r($row);
//    echo '</pre>';
//}



/*    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><values/>');*/
//
//
//    foreach ($catalogRUB as $k => $v) {
//        $xml->addChild($k, $v);
//    }
//
//    echo $xml->asXML();




//
//    $xml = new SimpleXMLElement('<root/>');
//
//// This function resursively added element
//// of array to xml document
//    array_walk_recursive($catalogRUB, array ($xml, 'addChild'));
//
//// This function prints xml document.
//    print $xml->asXML();


/*    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><values/>');*/
//    array_walk_recursive($catalogRUB, array ($xml,'addChild'));
//    print $xml->asXML();


    function generateXML($data) {
        $title = $data['shop']['name'];
        $rowCount = count($data['shop']['offers']['offer']);

        //create the xml document
        $xmlDoc = new DOMDocument();

        $root = $xmlDoc->appendChild($xmlDoc->createElement("offers"));
        $root->appendChild($xmlDoc->createElement("title",$title));
        $root->appendChild($xmlDoc->createElement("totalRows",$rowCount));
        $tabUsers = $root->appendChild($xmlDoc->createElement('rows'));

        foreach($data['shop']['offer']['offer'] as $user){
            if(!empty($user)){
                $tabUser = $tabUsers->appendChild($xmlDoc->createElement('offer'));
                foreach($user as $key=>$val){
                    $tabUser->appendChild($xmlDoc->createElement($key, $val));
                }
            }
        }

        header("Content-Type: text/plain");

        //make the output pretty
        $xmlDoc->formatOutput = true;

        //save xml file
        $file_name = str_replace(' ', '_','test').'.xml';
        $xmlDoc->save($file_name);

        //return xml file name
        return $file_name;
    }


    generateXML($catalogRUB);

















} else {
    exit('error');
}
?>
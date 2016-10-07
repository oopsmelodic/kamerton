<?php
include 'conn.php';
set_time_limit (30);
$search =iconv(mb_detect_encoding($_POST['search'], mb_detect_order(), true), "UTF-8", $_POST['search']);
$filter = $_POST['filter'];
$label = $_POST['label'];//"Life news";
$start = $_POST['start'];
$end = $_POST['end'];
$dateParam="%28RANGE%7B" . $start . "e%2C" . $end . "e%7D%3Aautn_date%29+AND+";
//if($start=="") {$dateParam="";}
$attitude = getXML("http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=News%2CVideo%2CIntegrum&dateOffset=-10800&datePeriod=day&documentcount=true&expandquery=true&FieldName=autn_date&FieldText=".$dateParam."MATCH%7B". $label ."%7D%3A".$filter."+AND+MATCH%7BNews%2CVideo%2CIntegrum%7D%3Aautn_database&matchAllTerms=false&outputencoding=UTF8&predict=true&sentences=0&text=" . $search . "&userID=Demo&xmlmeta=true");
$result = $attitude->xpath('/autnresponse/responsedata/autn:field//autn:value');
$db="[";
while (list(, $node) = each($result)) 
        {
            //echo $node['date'] . ": " . $node['count'] . "<BR>";
            $db= $db."{'filterLabel':'".explode("/",explode(" ", $node['date'])[1])[2]."/".explode("/",explode(" ", $node['date'])[1])[1]."/".explode("/",explode(" ", $node['date'])[1])[0]."','doccount':'".$node['count']."'},";
        }
$json=str_replace("'",'"',substr($db, 0, -1));
$json=$json."]";

echo $json; //json_encode($json);

function getXML($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents
    $data = curl_exec($ch); // execute curl request
    curl_close($ch);
    return simplexml_load_string($data);
}
?>
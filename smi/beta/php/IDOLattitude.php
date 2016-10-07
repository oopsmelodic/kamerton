<?php
include 'conn.php';
set_time_limit (30);
$text = iconv(mb_detect_encoding($_POST['search'], mb_detect_order(), true), "UTF-8", $_POST['search']);
$filter = $_POST['filter'];
$start = $_POST['start'];
$end = $_POST['end'];
$dateParam="%28RANGE%7B" . $start . "e%2C" . $end . "e%7D%3Aautn_date%29+AND+";
if($start=="") {$dateParam="";}
$names = array();
$source = getXML("http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=Archive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&documentcount=true&expandquery=true&FieldName=" . $filter . "&FieldText=".$dateParam."MATCH%7BArchive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B21%2F09%2F2015%2C2592000%2C25%7D%3Aautn_date&matchAllTerms=false&MaxValues=50&outputencoding=UTF8&predict=true&sentences=0&sort=DocumentCount&start=1&Text=" . $text . "&userID=Demo&xmlmeta=true");
$result = $source->xpath('/autnresponse/responsedata/autn:field//autn:value');
while (list(, $node) = each($result)) {
    $names[] = $node;
}

$count = count($names);
$db = "[";
for ($i = 0; $i < $count; $i++) {
    $attitude = getXML("http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=Archive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&documentcount=true&expandquery=true&FieldName=OVERALL_VIBE&FieldText=".$dateParam."MATCH%7B" . $names[$i] . "%7D%3A" . $filter . "+AND+MATCH%7BArchive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database&matchAllTerms=false&outputencoding=UTF8&predict=true&sentences=0&text=" . $text . "&userID=Demo&xmlmeta=true");
    $result = $attitude->xpath('/autnresponse/responsedata/autn:field//autn:value');
    $pos = 0;
    $neutr = 0;
    $neg = 0;
    while (list(, $node) = each($result)) {
        if ($node == "ПОЗИТИВ") {
            $pos = $node['count'];
        } else if ($node == "СМЕШАННЫЙ") {
            $neutr = $node['count'];
        } else if ($node == "НЕГАТИВ") {
            $neg = $node['count'];
        }
    }
    $db = $db . "{'filterLabel':'" . $names[$i] . "','positive':" . $pos . ",'neutral':" . $neutr . ",'negative':" . $neg . ",'docsum':" . ($neutr + $neg + $pos) . "},";
}
$json = str_replace("'", '"', substr($db, 0, -1));
$json = $json . "]";
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
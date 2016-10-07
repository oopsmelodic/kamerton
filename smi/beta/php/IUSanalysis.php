<?php

include 'conn.php';
ini_set("display_errors", 1);
$text="*";
$names = array();
$source = getXML("http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=Archive%2Csmianalyze%2CNews%2CVideo&documentcount=true&expandquery=true&FieldName=BROADCASTER&FieldText=MATCH%7BArchive%2Csmianalyze%2CNews%2CVideo%7D%3Aautn_database+AND+BIASDATE%7B16%2F09%2F2015%2C2592000%2C25%7D%3Aautn_date&matchAllTerms=false&MaxValues=20&outputencoding=UTF8&predict=true&sentences=0&sort=DocumentCount&start=1&Text=.$text.&userID=Demo&xmlmeta=true");
$result = $source->xpath('/autnresponse/responsedata/autn:field//autn:value');
while (list(, $node) = each($result)) {
    $names[] = $node;
}

$count = count($names);
$db = "[";
for ($i = 0; $i < $count; $i++) {
    $attitude = getXML("http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=Archive%2Csmianalyze%2CNews%2CVideo&documentcount=true&expandquery=true&FieldName=OVERALL_VIBE&FieldText=MATCH%7B" . $names[$i] . "%7D%3ABROADCASTER+AND+MATCH%7BArchive%2Csmianalyze%2CNews%2CVideo%7D%3Aautn_database&matchAllTerms=false&outputencoding=UTF8&predict=true&sentences=0&text=" . $text . "&userID=Demo&xmlmeta=true");
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
    $db = $db . "{'smiName':'" . $names[$i] . "','positive':" . $pos . ",'neutral':" . $neutr . ",'negative':" . $neg . "},";
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
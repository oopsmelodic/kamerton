<?php
include 'conn.php';
ini_set("display_errors", 1);
$search = "Путин";//$_POST['search'];
$filter = "BROADCASTER";//$_POST['filter'];
$query = "SELECT `filterLabel`, `docsum` FROM `doccount` WHERE `searchText`='" . $search . "' AND `searchFilter`='".$filter."'";
$result = mysql_query($query) or die("Ошибка поиска данных");

if ($result && mysql_num_rows($result) == 0) {
    //echo 'Скачиваем запрос по слову "' . $search . '" из IDOL<BR>';
    loadIDOL($search,$filter);
    returnJSON($search,$filter);
} else if ($result) {
    //echo 'Результаты по слову "' . $search . '" найдены<BR>';
    returnJSON($search,$filter);
}

function returnJSON($search,$filter) {
    $query = "SELECT `filterLabel`, `docsum` FROM `doccount` WHERE `searchText`='" . $search . "' AND `searchFilter`='".$filter."'";
    $result = mysql_query($query) or die("Ошибка поиска данных");
    if ($result && mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $db[] = $row;
        }
        echo var_dump($db);
        echo "<br><br>";
        echo json_encode($db);
    }
    else if($result && mysql_num_rows($result) == 0)
        echo "Данные не были найдены";
}

function getXML($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents
    $data = curl_exec($ch); // execute curl request
    curl_close($ch);
    return simplexml_load_string($data);
}

function loadIDOL($text,$filter) {
    $names = array();
    $source = getXML("http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=Archive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&documentcount=true&expandquery=true&FieldName=".$filter."&FieldText=MATCH%7BArchive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B21%2F09%2F2015%2C2592000%2C25%7D%3Aautn_date&matchAllTerms=false&MaxValues=50&outputencoding=UTF8&predict=true&sentences=0&sort=DocumentCount&start=1&Text=".$text."&userID=Demo&xmlmeta=true");
    $result = $source->xpath('/autnresponse/responsedata/autn:field//autn:value');
    while (list(, $node) = each($result)) {
        $names[] = $node;
    }

    $count = count($names);
    for ($i = 0; $i < $count; $i++) {
        //echo "<BR>Источник: " . $names[$i] . "<BR>";
        $attitude = getXML("http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=News%2CVideo%2CIntegrum&dateOffset=-10800&datePeriod=day&documentcount=true&expandquery=true&FieldName=autn_date&FieldText=MATCH%7B". $names[$i] ."%7D%3A".$filter."+AND+MATCH%7BNews%2CVideo%2CIntegrum%7D%3Aautn_database&matchAllTerms=false&outputencoding=UTF8&predict=true&sentences=0&text=" . $text . "&userID=Demo&xmlmeta=true");
        $result = $attitude->xpath('/autnresponse/responsedata/autn:field//autn:value');
        $docsum = 0;
        while (list(, $node) = each($result)) {
            //echo $node . ": " . $node['count'] . "<BR>";
            $docsum += $node['count'];
        }
        $query = "INSERT INTO `doccount`(`searchText`,`filterLabel`, `searchFilter`, `docsum`) VALUES ('" . $text . "','" . $names[$i] . "','" . $filter . "'," . $docsum.")";
        mysql_query($query) or die("Ошибка добавления строки"); //вытащили
    }
}
// Данные !! http://10.153.0.36:9000/Action=Query&characters=500&combine=simple&databaseMatch=Archive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&EndTag=%7BiMhlc%7D&expandquery=true&FieldText=MATCH%7BArchive%2CVideo%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B21%2F09%2F2015%2C2592000%2C25%7D%3Aautn_date&highlight=terms%2Bsummaryterms&matchAllTerms=false&maxresults=10&outputencoding=UTF8&predict=true&Print=Fields&PrintFields=POSITIVE_VIBE%2CNEGATIVE_VIBE%2CPOST_IMG%2COVERALL_VIBE%2CASSET_ID%2CAUTHOR%2CSOURCESITE%2CDREREFERENCE%2CDRETITLE%2CDREDATE%2CDREDBNAME%2CIUS_LIKE_*%2CIMPORTMAGICEXTENSION%2CAUTN_IDENTIFIER%2CIUS_COMMENTS_COUNT%2CIUS_RATING_AVERAGE%2CIUS_RATING_COUNT%2CIM_VOTE_UP%2CSUBFILETYPE%2CLOOSE_MAIL_TYPE%2CATTACHMENT%2CMAIL%2CDREPARENTREFERENCE%2CDREROOTFAMILYREFERENCE%2C_TAG_SPE_DEMO%2C_TAG__PUBLIC%2CIM_PARENT_PATH&queryPageSize=10&sentences=0&sort=Relevance%2BDate&Spellcheck=true&start=1&StartTag=%7BiMhlo%7D&summary=context&Text=%D0%9F%D1%83%D1%82%D0%B8%D0%BD&TotalResults=true&userID=Demo&WeighFieldText=false&xmlmeta=true
//http://10.153.0.36:9000/Action=GetQueryTagValues&combine=simple&databaseMatch=News%2CVideo%2CIntegrum&dateOffset=-10800&datePeriod=day&documentcount=true&expandquery=true&FieldName=autn_date&FieldText=MATCH%7BLife+news%7D%3ABROADCASTER+AND+MATCH%7BNews%2CVideo%2CIntegrum%7D%3Aautn_database&matchAllTerms=false&outputencoding=UTF8&predict=true&sentences=0&text=*&userID=Demo&xmlmeta=true
?>
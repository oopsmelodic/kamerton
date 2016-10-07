<?php
set_time_limit (30);
include 'conn.php';
ini_set("display_errors", 1);
$search = iconv(mb_detect_encoding($_POST['search'], mb_detect_order(), true), "UTF-8", $_POST['search']);
$page = $_POST['page'];
$filter = $_POST['filter'];
$label = $_POST['label'];//"Life news";
$filterLabels="";
if($label!="" && $filter!="") {$filterLabels="MATCH%7B" . $label . "%7D%3A" . $filter . "+AND+";}

$start ="";// $_POST['start'];
$end = $_POST['end'];
$dateParam = "%28RANGE%7B" . $start . "e%2C" . $end . "e%7D%3Aautn_date%29+AND+";
if ($start == "") {$dateParam = "";}
$attitude = getXML("http://10.153.0.36:9000/Action=Query&responseFormat=json&characters=500&combine=simple&databaseMatch=Video%2CNews%2CIntegrum&EndTag=%7BiMhlc%7D&expandquery=true"
        ."&FieldText="
        . ( $filterLabels!="" ? $filterLabels:"") 
        ."MATCH%7BVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B13%2F10%2F2015%2C2592000%2C25%7D%3Aautn_date&highlight=terms%2Bsummaryterms&matchAllTerms=false&maxresults="
        .(10+$page-1)."&outputencoding=UTF8&predict=true&Print=Fields"
        ."&PrintFields=POSITIVE_VIBE%2CNEGATIVE_VIBE%2CPOST_IMG%2COVERALL_VIBE%2CASSET_ID%2CAUTHOR%2CSOURCESITE%2CDREREFERENCE%2CDRETITLE%2CDREDATE%2CDREDBNAME%2CIUS_LIKE_*%2CIMPORTMAGICEXTENSION%2CAUTN_IDENTIFIER%2CIUS_COMMENTS_COUNT%2CIUS_RATING_AVERAGE%2CIUS_RATING_COUNT%2CIM_VOTE_UP%2CSUBFILETYPE%2CLOOSE_MAIL_TYPE%2CATTACHMENT%2CMAIL%2CDREPARENTREFERENCE%2CDREROOTFAMILYREFERENCE%2C_TAG_SPE_DEMO%2C_TAG__PUBLIC%2CIM_PARENT_PATH"
        ."&queryPageSize=10&sentences=0&sort=Date%2BRelevance&Spellcheck=true&start=".$page."&StartTag=%7BiMhlo%7D&summary=context&Text=" 
        . $search . "&TotalResults=true&userID=Demo&WeighFieldText=false&xmlmeta=true");
//$attitude = getXML("http://10.153.0.36:9000/Action=Query&responseFormat=json&characters=500&combine=simple&databaseMatch=Integrum%2Csmianalyze%2CNews%2Ckribrum%2CVideo%2CIntegrum%2Csmianalyze%2CNews%2Ckribrum%2CVideo&EndTag=%7BiMhlc%7D&expandquery=true".(($filterLabels=="" && $filter!="") ? "&FieldName=".$filter ."&":"")."&FieldText=". ( $filterLabels!="" ? $filterLabels:"") . $dateParam . "MATCH%7BIntegrum%2Csmianalyze%2CNews%2Ckribrum%2CVideo%2CIntegrum%2Csmianalyze%2CNews%2Ckribrum%2CVideo%7D%3Aautn_database+AND+BIASDATE%7B07%2F10%2F2015%2C2592000%2C25%7D%3Aautn_date&highlight=terms%2Bsummaryterms&matchAllTerms=false&maxresults=10&outputencoding=UTF8&predict=true&Print=Fields&PrintFields=POSITIVE_VIBE%2CNEGATIVE_VIBE%2CPOST_IMG%2COVERALL_VIBE%2CASSET_ID%2CAUTHOR%2CSOURCESITE%2CDREREFERENCE%2CDRETITLE%2CDREDATE%2CDREDBNAME%2CIUS_LIKE_*%2CIMPORTMAGICEXTENSION%2CAUTN_IDENTIFIER%2CIUS_COMMENTS_COUNT%2CIUS_RATING_AVERAGE%2CIUS_RATING_COUNT%2CIM_VOTE_UP%2CSUBFILETYPE%2CLOOSE_MAIL_TYPE%2CATTACHMENT%2CMAIL%2CDREPARENTREFERENCE%2CDREROOTFAMILYREFERENCE%2C_TAG_SPE_DEMO%2C_TAG__PUBLIC%2CIM_PARENT_PATH&queryPageSize=10&sentences=0&sort=Relevance%2BDate&Spellcheck=true&start=1&StartTag=%7BiMhlo%7D&summary=context&Text=" . $search . "&TotalResults=true&userID=Demo&WeighFieldText=false&xmlmeta=true");
echo $attitude;
function getXML($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents
    $data = curl_exec($ch); // execute curl request
    curl_close($ch);
    return $data;//simplexml_load_string($data);
}
//http://10.153.0.36:9000/Action=Query&characters=500&combine=simple&databaseMatch=Video%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&EndTag=%7BiMhlc%7D&expandquery=true&FieldText=MATCH%7BVideo%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B14%2F10%2F2015%2C2592000%2C25%7D%3Aautn_date&highlight=terms%2Bsummaryterms&languageType=arabicUTF8&matchAllTerms=false&maxresults=20&outputencoding=UTF8&predict=true&Print=Fields&PrintFields=POSITIVE_VIBE%2CNEGATIVE_VIBE%2CPOST_IMG%2COVERALL_VIBE%2CASSET_ID%2CAUTHOR%2CSOURCESITE%2CDREREFERENCE%2CDRETITLE%2CDREDATE%2CDREDBNAME%2CIUS_LIKE_*%2CIMPORTMAGICEXTENSION%2CAUTN_IDENTIFIER%2CIUS_COMMENTS_COUNT%2CIUS_RATING_AVERAGE%2CIUS_RATING_COUNT%2CIM_VOTE_UP%2CSUBFILETYPE%2CLOOSE_MAIL_TYPE%2CATTACHMENT%2CMAIL%2CDREPARENTREFERENCE%2CDREROOTFAMILYREFERENCE%2C_TAG_SPE_DEMO%2C_TAG__PUBLIC%2CIM_PARENT_PATH&queryPageSize=10&sentences=0&sort=Relevance%2BDate&Spellcheck=true&start=11&StartTag=%7BiMhlo%7D&summary=context&Text=*&TotalResults=true&userID=Demo&WeighFieldText=false&xmlmeta=true
////http://10.153.0.36:9000/Action=Query&characters=500&combine=simple&databaseMatch=Video%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&EndTag=%7BiMhlc%7D&expandquery=true&FieldText=MATCH%7BVideo%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B14%2F10%2F2015%2C2592000%2C25%7D%3Aautn_date&highlight=terms%2Bsummaryterms&languageType=arabicUTF8&matchAllTerms=false&maxresults=10&outputencoding=UTF8&predict=true&Print=Fields&PrintFields=POSITIVE_VIBE%2CNEGATIVE_VIBE%2CPOST_IMG%2COVERALL_VIBE%2CASSET_ID%2CAUTHOR%2CSOURCESITE%2CDREREFERENCE%2CDRETITLE%2CDREDATE%2CDREDBNAME%2CIUS_LIKE_*%2CIMPORTMAGICEXTENSION%2CAUTN_IDENTIFIER%2CIUS_COMMENTS_COUNT%2CIUS_RATING_AVERAGE%2CIUS_RATING_COUNT%2CIM_VOTE_UP%2CSUBFILETYPE%2CLOOSE_MAIL_TYPE%2CATTACHMENT%2CMAIL%2CDREPARENTREFERENCE%2CDREROOTFAMILYREFERENCE%2C_TAG_SPE_DEMO%2C_TAG__PUBLIC%2CIM_PARENT_PATH&queryPageSize=10&sentences=0&sort=Relevance%2BDate&Spellcheck=true&start=1&StartTag=%7BiMhlo%7D&summary=context&Text=*&TotalResults=true&userID=Demo&WeighFieldText=false&xmlmeta=true
//
//http://10.153.0.36:9000/Action=Query&characters=500&combine=simple&databaseMatch=Video%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&EndTag=%7BiMhlc%7D&expandquery=true&FieldText=MATCH%7BVideo%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B14%2F10%2F2015%2C2592000%2C25%7D%3Aautn_date&highlight=terms%2Bsummaryterms&languageType=arabicUTF8&matchAllTerms=false&maxresults=20&outputencoding=UTF8&predict=true&Print=Fields&PrintFields=POSITIVE_VIBE%2CNEGATIVE_VIBE%2CPOST_IMG%2COVERALL_VIBE%2CASSET_ID%2CAUTHOR%2CSOURCESITE%2CDREREFERENCE%2CDRETITLE%2CDREDATE%2CDREDBNAME%2CIUS_LIKE_*%2CIMPORTMAGICEXTENSION%2CAUTN_IDENTIFIER%2CIUS_COMMENTS_COUNT%2CIUS_RATING_AVERAGE%2CIUS_RATING_COUNT%2CIM_VOTE_UP%2CSUBFILETYPE%2CLOOSE_MAIL_TYPE%2CATTACHMENT%2CMAIL%2CDREPARENTREFERENCE%2CDREROOTFAMILYREFERENCE%2C_TAG_SPE_DEMO%2C_TAG__PUBLIC%2CIM_PARENT_PATH&queryPageSize=10&sentences=0&sort=Relevance%2BDate&Spellcheck=true&start=11&StartTag=%7BiMhlo%7D&summary=context&Text=*&TotalResults=true&userID=Demo&WeighFieldText=false&xmlmeta=true
//http://10.153.0.36:9000/Action=Query&characters=500&combine=simple&databaseMatch=Video%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum&EndTag=%7BiMhlc%7D&expandquery=true&FieldText=MATCH%7BVideo%2Ckribrum%2Csmianalyze%2CNews%2CIntegrum%2CVideo%2CNews%2CIntegrum%7D%3Aautn_database+AND+BIASDATE%7B14%2F10%2F2015%2C2592000%2C25%7D%3Aautn_date&highlight=terms%2Bsummaryterms&languageType=arabicUTF8&matchAllTerms=false&maxresults=10&outputencoding=UTF8&predict=true&Print=Fields&PrintFields=POSITIVE_VIBE%2CNEGATIVE_VIBE%2CPOST_IMG%2COVERALL_VIBE%2CASSET_ID%2CAUTHOR%2CSOURCESITE%2CDREREFERENCE%2CDRETITLE%2CDREDATE%2CDREDBNAME%2CIUS_LIKE_*%2CIMPORTMAGICEXTENSION%2CAUTN_IDENTIFIER%2CIUS_COMMENTS_COUNT%2CIUS_RATING_AVERAGE%2CIUS_RATING_COUNT%2CIM_VOTE_UP%2CSUBFILETYPE%2CLOOSE_MAIL_TYPE%2CATTACHMENT%2CMAIL%2CDREPARENTREFERENCE%2CDREROOTFAMILYREFERENCE%2C_TAG_SPE_DEMO%2C_TAG__PUBLIC%2CIM_PARENT_PATH&queryPageSize=10&sentences=0&sort=Relevance%2BDate&Spellcheck=true&start=1 &StartTag=%7BiMhlo%7D&summary=context&Text=*&TotalResults=true&userID=Demo&WeighFieldText=false&xmlmeta=true

//////$result1 = $attitude->xpath('/autnresponse/responsedata/autn:hit/autn:title'); //
////echo strval($result1[0]);
//
//$result = $attitude->xpath('/autnresponse/responsedata/autn:hit'); ///autn:title/text()
//$cnt = count($result);
//for($i=1;$i<=$cnt;$i++)
//{
//    $title = $attitude->xpath('/autnresponse/responsedata/autn:hit['.$i.']/autn:title/text()');
//    $content = $attitude->xpath('/autnresponse/responsedata/autn:hit['.$i.']/autn:summary/text()');
//    echo "Новость №".($i).". Заголовок: ".strval($title[0])."<BR>Содержание: ".strval($content[0])."<BR><BR>";
//}
////while (list(, $node) = each($result)) {
////    //echo var_dump($node->xpath('/autn:title/text()'));    
////    $title = $node->xpath('/autn:title/text()');
////    //echo strval($title[0]);
////    //$db= $db."{'filterLabel':'".explode("/",explode(" ", $node['date'])[1])[2]."/".explode("/",explode(" ", $node['date'])[1])[1]."/".explode("/",explode(" ", $node['date'])[1])[0]."','doccount':'".$node['count']."'},";
////}
//
////$db="[";
////while (list(, $node) = each($result)) 
////        {
////            //echo $node['date'] . ": " . $node['count'] . "<BR>";
////            $db= $db."{'filterLabel':'".explode("/",explode(" ", $node['date'])[1])[2]."/".explode("/",explode(" ", $node['date'])[1])[1]."/".explode("/",explode(" ", $node['date'])[1])[0]."','doccount':'".$node['count']."'},";
////        }
////$json=str_replace("'",'"',substr($db, 0, -1));
////$json=$json."]";
////echo $json; //json_encode($json);
?>
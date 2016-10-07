<?php
include 'conn.php';
//$query = "SELECT joinID,YandexsiteName,gosReestrName,liveinternetName,liveLink,visitersMonth,visitersRussiaPercentage,views,session,visitors,hosts,reloads,citationRate,founder,category,inn,address FROM `smistat`"; //тащим таблицу
//$result = mysql_query($query) or die("asdasd");//вытащили
$jsonString = '{ shortName: "ЗАО "ПФ "СКБ Контур"", longName: "Закрытое акционерное общество "Производственная фирма "СКБ Контур"", inn: "6663003127", ogrn: "1026605606620", okpo: "00242766", regDate: "1992-03-26", statusText: "Действующее", statusEx: { active: true, liquidated: false, liquidating: false, reorganizing: false }, address: { zip: "620017", regionCode: "66", regionName: { abbr: "обл", abbrEx: "область", value: "Свердловская" }, city: { abbr: "г", abbrEx: "город", value: "Екатеринбург" }, street: { abbr: "пр-кт", abbrEx: "проспект", value: "Космонавтов" }, house: { abbr: "дом", abbrEx: "дом", value: "56" }, date: "2008-12-19", houseRegsCount_ESTIMATE: 59, flatRegsCount_ESTIMATE: 59 }, mainActivity: { code: "72.20", text: "Разработка программного обеспечения и консультирование в этой области" }, activities: [ { code: "72.20", text: "Разработка программного обеспечения и консультирование в этой области" } ], heads: [ { fio: "Мраморов Дмитрий Михайлович", inn: "744800102483", date: "2010-02-11", fioMentionsCount_ESTIMATE: 4 } ], capital: { sum: 5465115, date: "2008-05-07" }, pfrRegNumber: "075033001392", fomsRegNumber: "654019370010182", foundedULCount_ESTIMATE: 11, courtsCasesStat: { plaintiff: { count_12month_ESTIMATE: 4, totalSum_12month_ESTIMATE: 8018823.71, count_ESTIMATE: 17, totalSum_ESTIMATE: 10867367.61 }, defendant: { count_12month_ESTIMATE: 6, totalSum_12month_ESTIMATE: 2328201.27, count_ESTIMATE: 9, totalSum_ESTIMATE: 2398657.27 } }, govContractsStat: { offered: { count_12month_ESTIMATE: 376, totalSum_12month_ESTIMATE: 73425539.72, count_ESTIMATE: 823, totalSum_ESTIMATE: 133265914.2 } }, internetMentionsStat: { mentionsCount_ESTIMATE: 86 }, tradeMarksStat: { mentionsCount_ESTIMATE: 28 }, financialStatementsStat: { latestYear_ESTIMATE: 2012 }, href: "https://focus.kontur.ru/entity?query=1026605606620" }';
$valid_json = preg_replace('/([{\[,])\s*([a-zA-Z0-9_]+?):/', '$1"$2":', $jsonString);
echo $valid_json;
echo "<br>";
echo "<br>";
echo $json;
        $json = str_replace('{"', '{\'', $valid_json);
        $json= str_replace('null', '"null"', $json);
        $json = str_replace('":"', '\':\'', $json);
        $json = str_replace('","', '\',\'', $json);
        $json = str_replace('"}', '\'}', $json);
        $json = str_replace('"', '\"', $json);
        $json = str_replace('\'', '"', $json);
















echo $json;
echo "<br>";
var_dump(json_decode($json,true));
//if($data["id"]==null) echo "ноль есть"

//$jsonArray = json_decode($jsonString, true);

//$query='INSERT INTO test131 (name, school, city, id) VALUES (?,?,?,?)'.$jsonArray['name'].$jsonArray['school'].$jsonArray['city'].$jsonArray['id'];

?>
<?php
include 'conn.php';
$query = "SELECT joinID,YandexsiteName,gosReestrName,liveinternetName,liveLink,visitersMonth,visitersRussiaPercentage,views,session,visitors,hosts,reloads,citationRate,founder,category,inn,address FROM `smistat`"; //тащим таблицу
$result = mysql_query($query) or die("asdasd");//вытащили
$json='[';

if ($result){//если был результат
	while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) { 
		$db[]=$row;
	}
	echo json_encode($db);
}
?>
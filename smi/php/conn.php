<?php
    $hostname = 'localhost';
    $user = 'smi';
    $mysql_pwd = '123';
    $link = mysql_connect($hostname, $user, $mysql_pwd)
        or die;//('Не удалось соединиться: ' . mysql_error());
    mysql_select_db('smi');// or die('Не удалось выбрать базу данных');
    mysql_set_charset( 'utf8' );
    mysql_query("set names 'utf8'");
	set_time_limit(0);
	//echo('done');
?>
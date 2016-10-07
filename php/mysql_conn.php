<?php
    $hostname = 'localhost';
    $user = 'root';
    $password = '123';
    $link = mysql_connect($hostname, $user, $password)
        or die('Не удалось соединиться: ' . mysql_error());
    mysql_select_db('inline') or die('Не удалось выбрать базу данных');
    mysql_set_charset( 'utf8' );
    mysql_query("set names 'utf8'");
?>

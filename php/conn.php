<?php
    $hostname = 'localhost';
    $user = 'inline';
    $mysql_pwd = '537235';
    $link = mysql_connect($hostname, $user, $mysql_pwd)
        or die('Не удалось соединиться: ' . mysql_error());
    mysql_select_db('inline') or die('Не удалось выбрать базу данных');
    mysql_set_charset( 'utf8' );
    mysql_query("set names 'utf8'");
    
    
    function mylog($action,$type='primary'){    
        $uid = isset($_SESSION['UID'])?$_SESSION['UID']:0;
        $sql= "Insert Into dblogs (uiid,sesid,fromip,action,type) Values('".$uid."','".session_id()."','".$_SERVER['REMOTE_ADDR']."','".$action."','".$type."')";
        mysql_query($sql);
    }    
?>

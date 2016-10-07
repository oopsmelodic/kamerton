<?php

ini_set('default_charset','UTF-8');

$link = mysql_connect('localhost', 'root', '')
    or die('Не удалось соединиться: ' . mysql_error());

mysql_select_db('inline');
mysql_query("set names 'utf8'");

$login = $_POST['login'];
$pwd = $_POST['pwd'];

if ($login!=null && $pwd!=null){
    $query = mysql_query("Select * From dbusers Where login='$login' and pwd='$pwd'") or die('Запрос не удался: ' . mysql_error());
    $row = mysql_fetch_assoc($query);
    if ($query){
        $data['id'] = $row['id'];
        $data['login'] = $row['login'];
        $data['pwd'] = $row['pwd']; 
        $data['fio'] = $row['fio'];
        if ($row['login']!=''){
            echo json_encode($row);
        }
        else{
            echo null;
        }
        }
}
mysql_free_result($query);

?>

<?php
    ini_set('default_charset','UTF-8');

    $link = mysql_connect('localhost', 'root', '')
        or die('Не удалось соединиться: ' . mysql_error());

    mysql_select_db('inline');
    mysql_query("set names 'utf8'");
    
    $dir = "../files/";
    $files = scandir($dir);
    
    for ($index = 0; $index < count($files); $index++) {
        
        mysql_query("Insert Into dbfilenames (catid,filename,processed,type,filepath,filelang) ".
                    "Values ('1','".$timestart."','".$timeend."','".$value."','".  strlen($value)."')");
        
    
    }


?>

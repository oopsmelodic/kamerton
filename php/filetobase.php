<?php
header('Content-Type: text/html; charset=utf-8');
    $hostname = 'localhost';
    $user = 'root';
    $pwd = '';
    $filepath = '../files/temp/';
    $link = mysql_connect($hostname, $user, $pwd)
        or die('Не удалось соединиться: ' . mysql_error());
    mysql_select_db('inline') or die('Не удалось выбрать базу данных');
    mysql_set_charset( 'utf8' );
    $fp = fopen( $filepath.'video_23fd6047a3bb614112df3d15c95bc5ea.ctm','r');
    if ($fp) {
        $mass = array();
        $i =0;
        while (!feof($fp)){
            $str = fgets($fp, 4089);
            list($num,$type,$timestart,$timeend,$value,$length) = explode(' ', $str);            
            $value = str_replace('<s>', '.', $value);
            $value = str_replace('<SIL>', '...', $value);;
            $mass[$i] = array(
                "timestart" => $timestart,
                "timeend" => $timestart+$timeend,
                "value"=> $value
            );
            $i++;            
        }
        $SPACER = ' ';
        for ($i=0; $i<=count($mass);$i++){
                if ($mass[$i]['value']!= '.' and $mass[$i]['value']!='...'){
                    if ($wordcount>0){
                        $row['value'] .= $SPACER.$mass[$i]['value'];
                    }else{
                        $row['value'] .= $mass[$i]['value'];
                        $row['timestart'] = $mass[$i]['timestart'];
                    }              
                    $wordcount++;
                }else{
                    if ($wordcount>0){                          
                        $row['timeend']= $mass[$i]['timestart'];
                        echo 'TimeStart: '.$row['timestart'].' TimeEnd: '.$row['timeend'].' Val: '.$row['value'].'<br>';
//                        $sql = "Insert Into dbfilestext (fileid,timestart,timeend,text) ".
//                                "Values('1','".$row['timestart']."','".$row['timeend']."','".$row['value']."')";
//                        mysql_query($sql);  
//                        $sql = "Update dbfilenames Set processed='1' Where id='1'";
//                        mysql_query($sql); 
                        $row['value'] = '';
                        $wordcount = 0;
                    }
                }
        }        
    }
    else echo "Ошибка при открытии файла";
    fclose($fp);    

?>
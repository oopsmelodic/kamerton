<?php
    $mainpath = '/usr/share/nginx/www/';
    $hostname = 'localhost';
    $user = 'root';
    $pwd = '123';
    $link = mysql_connect($hostname, $user, $pwd)
        or die('Не удалось соединиться: ' . mysql_error());
    mysql_select_db('inline') or die('Не удалось выбрать базу данных');
    mysql_set_charset( 'utf8' );
    $fileid = $argv[1];
    $filename = $argv[2];   
    $taskid = $argv[3];
        $fp = fopen( $mainpath."files/temp/".$filename.".ctm",'r+');
        if ($fp) {
            $mass = array();
            $i =0;
            while (!feof($fp)){
                $str = fgets($fp, 4089);
                list($num,$type,$timestart,$timeend,$value,$length) = explode(' ', $str);
                $value = str_replace('<s>', '.', $value);
                $value = str_replace('<SIL>', '...', $value);
                $mass[$i] = array(
                    "timestart" => $timestart,
                    "timeend" => $timestart+$timeend,
                    "value"=> $value
                );
                $i++;            
            }
            $SPACER = ' ';           
            for ($i=0; $i<count($mass);$i++){           
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
                            $sql = "Insert Into dbfilestext (fileid,timestart,timeend,text) ".
                                    "Values('".$fileid."','".$row['timestart']."','".$row['timeend']."','".$row['value']."')";
                            mysql_query($sql);  
                            $sql = "Update dbfilenames Set processed='4' Where id='".$fileid."'";
                            mysql_query($sql); 
                            $row['value'] = '';
                            $wordcount = 0;
                        }
                    }
            } 
            $sql = "Update dbtasks Set status='4' Where id='".$taskid."'";
            mysql_query($sql);
        }else{
            $sql = "Update dbtasks Set status='101' Where id='".$taskid."'";
            mysql_query($sql);
        }
        fclose($fp);          
?>

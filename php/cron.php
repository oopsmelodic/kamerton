<?php
    $mainpath = '/var/www/main/';
    ini_set("display_errors",1);  
//    $fp =fopen('/usr/share/nginx/www/files/temp/123.txt', 'w+');
    
//    $hostname = 'localhost';
//    $user = 'root';
//    $pwd = '123';
//    $link = mysql_connect($hostname, $user, $pwd)
//        or die('Не удалось соединиться: ' . mysql_error());
//    mysql_select_db('inline') or die('Не удалось выбрать базу данных');
//    mysql_set_charset( 'utf8' );
    
    include $mainpath.'php/conn.php';
    include $mainpath.'php/streaming.php';
    //echo '123';
//    $sql = "Select id,streamname,state From dbstreams";
//    $result = mysql_query($sql); 
//    if ($result) { 
//        $streams = vlc_view_streams();
////        print_r($streams); 
//        while ($row = mysql_fetch_array($result)) {
//            foreach ($streams as $key => $value) {
//                if ($value['name']==$row['streamname'] && $value['state']!='playing' && $value['type']=='http' && $row['state']=='1'){
//                    vlc_cmd_play($row['streamname']);
//                }
//            }
//        }       
//    }     
    //echo "LOL3"; 
    $query = "Select users.words as words, users.search_word as sw, file.type as filetype,task.id as taskid,task.fileid,task.type,task.urlfrom,task.fromtype,task.userid,task.status,file.filename,file.filepath,file.id,streams.source,streams.state,streams.record,streams.streamname,task.token,task.data1,task.data2 ".
                "From dbtasks as task ".
                "Left Join dbfilenames as file on task.fileid=file.id ".
                "Left Join dbstreams as streams on task.fileid=streams.id ".
                "Left Join dbusers as users on task.userid=users.id ".
                "Where status!=4 and status!=0 LIMIT 2";
     $result = mysql_query($query);
        
        if ($result){            
            while ($row = mysql_fetch_array($result)) { 
                echo "<br>"."ID:".$row['taskid']."  Status:".$row['status']; 
//                if ($row['status']=='loaded'){
//                    $path = str_replace('..', '/usr/share/nginx/www', $row['filepath']);
//                    $sql = "Update dbtasks Set status='inprogress' Where id='".$row['taskid']."'";
//                    mysql_query($sql);
////                    fwrite($fp,"nohup ".$mainpath."chronos/1.sh ".$mainpath." ".$path." ".$row['filename']." ".$row['id']." &");
//                    exec("nohup ".$mainpath."chronos/1.sh ".$mainpath." ".$path." ".$row['filename']." ".$row['id']." &");
////                    PsExecute("ffmpeg -i "
////                            .$path." -vn -ar 16000 -ac 1 -ab 192000 "
////                            .$mainpath."/files/temp/".$row['filename'].".wav");
////                    fwrite($fp, "ffmpeg -i "
////                            .$path." -vn -ar 16000 -ac 1 -ab 192000 "
////                            .$mainpath."/files/temp/".$row['filename'].".wav");
////                    PsExecute($mainpath."/chronos/chronosBasic "
////                            .$mainpath."/chronos/lang/RURU RURU-3.0 FAST "
////                            .$mainpath."/files/temp/".$row['filename'].".wav "
////                            .$mainpath."/files/temp/".$row['filename'].".ctm "
////                            .$mainpath."/files/temp/".$row['filename'].".log");
////                    PsExecute("/usr/bin/php ".$mainpath."php/ctmload.php ".$row['id']." ".$row['filename']);
//                }
                switch ($row['status']) {
                    case 3:
                            $path = str_replace('..', '/var/www/main/', $row['filepath']);
                            $sql = "Update dbtasks Set status='11' Where id='".$row['taskid']."'";
                            mysql_query($sql);
//                            fwrite($fp,"nohup ".$mainpath."chronos/1.sh ".$mainpath." ".$path." ".$row['filename']." ".$row['id']." &");
                            exec("nohup ".$mainpath."chronos/1.sh ".$mainpath." ".$path." ".$row['filename']." ".$row['id']." ".$row['taskid']." > /dev/null 2>&1 & echo $!");
                        break;
                    case 123:
                            parse_str( parse_url( $row['urlfrom'], PHP_URL_QUERY ), $my_array_of_vars );
                            $id =$my_array_of_vars['v'];
                            $path = str_replace('..', '/var/www/main/', $row['filepath']);
//                            echo '  DWNLOAD YOUTUBE: '.$id;
                            $sql = "Update dbtasks Set status='10' Where id='".$row['taskid']."'";
                            mysql_query($sql);          
//                            fwrite($fp,"/usr/bin/php ".$mainpath."php/donwloadyoutube.php ".$row['urlfrom']." ".$path." ".$row['fileid']." ".$row['taskid']." &");
                            exec("nohup /usr/bin/php ".$mainpath."php/downloadyoutube.php ".$id." ".$path." ".$row['fileid']." ".$row['taskid']." > /dev/null 2>&1 & echo $!");
                            echo "nohup /usr/bin/php ".$mainpath."php/downloadyoutube.php ".$id." ".$path." ".$row['fileid']." ".$row['taskid']." > /dev/null 2>&1 & echo $!";
                        break;
                    case 61:
                            $path = str_replace('..', '/var/www/main/', $row['filepath']);
                            $sql = "Update dbtasks Set status='11' Where id='".$row['taskid']."'";
                            mysql_query($sql);
//                            fwrite($fp,"nohup ".$mainpath."chronos/1.sh ".$mainpath." ".$path." ".$row['filename']." ".$row['id']." &");
                            exec("nohup /usr/bin/php ".$mainpath."php/StreamToText.php ".$row['taskid']." ".$row['filename']." ".$row['filetype']." > /dev/null 2>&1 & echo $!");
                            echo "nohup /usr/bin/php ".$mainpath."php/StreamToText.php ".$row['taskid']." ".$row['filename']." ".$row['filetype']." > /dev/null 2>&1 & echo $!";
                        break;
                    case 62:
//                            parse_str( parse_url( $row['urlfrom'], PHP_URL_QUERY ), $my_array_of_vars );
//                            $id =$my_array_of_vars['v'];
                            $path = str_replace('..', '/var/www/main/', $row['filepath']);
//                            echo '  DWNLOAD YOUTUBE: '.$id;
                            $sql = "Update dbtasks Set status='10' Where id='".$row['taskid']."'";
                            mysql_query($sql);          
//                            fwrite($fp,"/usr/bin/php ".$mainpath."php/donwloadyoutube.php ".$row['urlfrom']." ".$path." ".$row['fileid']." ".$row['taskid']." &");
                            exec("nohup /usr/bin/php ".$mainpath."php/getDataSpeech.php ".$row['fileid']." ".$row['filename']." ".$row['taskid']." ".$row['token']." ".$row['userid']." ".str_replace(' ',',',$row['words'])." ".$row['sw']." > /dev/null 2>&1 & echo $!");
                            echo "nohup /usr/bin/php ".$mainpath."php/getDataSpeech.php ".$row['fileid']." ".$row['filename']." ".$row['taskid']." ".$row['token']." ".$row['userid']." ".str_replace(' ',',',$row['words'])." ".$row['sw']." > /dev/null 2>&1 & echo $!";
                        break;
                    case 30:
                            $chunktime =10;
                            $sql = "Update dbtasks Set status='4' Where id='".$row['taskid']."'";
                            mysql_query($sql);                                
//                            fwrite($fp,"nohup ".$mainpath."chronos/streamr.sh ".$mainpath."files/temp/".$row['streamname'].".mp4"." ".$row['source']." ".$chunktime." > /dev/null 2>&1 & echo $!");
                            exec("nohup ".$mainpath."chronos/streamr.sh ".$mainpath."files/temp/".$row['streamname'].$row['taskid'].".mp4"." ".$row['source']." ".$chunktime." ".$row['streamname'].$row['taskid']." ".$row['fileid']." > /dev/null & echo $!");
                        break;
                    case 80:
//                            parse_str( parse_url( $row['urlfrom'], PHP_URL_QUERY ), $my_array_of_vars );
//                            $id =$my_array_of_vars['v'];
                            $path = str_replace('..', '/var/www/main/', $row['filepath']);
//                            echo '  DWNLOAD YOUTUBE: '.$id;
                            $sql = "Update dbtasks Set status='10' Where id='".$row['taskid']."'";
                            mysql_query($sql);          
//                            fwrite($fp,"/usr/bin/php ".$mainpath."php/donwloadyoutube.php ".$row['urlfrom']." ".$path." ".$row['fileid']." ".$row['taskid']." &");
                            echo "nohup /usr/bin/php ".$mainpath."php/searchFmd.php ".$row['userid']." ".$row['taskid']." ".$row['data2']." > /dev/null 2>&1 & echo $!";
                            exec("nohup /usr/bin/php ".$mainpath."php/searchFmd.php ".$row['userid']." ".$row['taskid']." ".$row['data2']." > /dev/null 2>&1 & echo $!");                            
                        break;
                    default:
                        break;
                }
            }
        }   
    
        
//        fclose($fp);
        
        
        
        function PsExecute($command, $timeout = 60, $sleep = 2) { 
          $pid = PsExec($command); 
          if( $pid === false ) 
              return false; 
          $cur = 0; 
          while( $cur < $timeout ) { 
              sleep($sleep); 
              $cur += $sleep; 
              if( !PsExists($pid) ) 
                  return true;
          }          
          PsKill($pid); 
          return false; 
      } 

      function PsExec($commandJob) { 
          $command = $commandJob.' > /dev/null 2>&1 & echo $!'; 
          exec($command ,$op); 
          $pid = (int)$op[0]; 
          if($pid!="") return $pid; 
          return false;
      } 

      function PsExists($pid) { 
          exec("ps ax | grep $pid 2>&1", $output); 
          while( list(,$row) = each($output) ) { 
                  $row_array = explode(" ", $row); 
                  $check_pid = $row_array[0]; 
                  if($pid == $check_pid) { 
                          return true; 
                  } 
          } 
          return false; 
      } 

      function PsKill($pid) { 
          exec("kill -9 $pid", $output); 
      }  
?>

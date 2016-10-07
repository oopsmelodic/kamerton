<?php
//    print_r($_SERVER);
    getWAV('video_3385b2568174a3d59fe34c08065d8a3f.mp4');
//$handle = @fopen("../files/temp/123.ctm", "r");
//if ($handle) {
//    while (($buffer = fgets($handle, 4096)) !== false) {
//        $replace = array('<SIL>','<s>');
////        str_replace($replace, "",$buffer)
//        print_r($mass = explode(' ', str_replace($replace, "",$buffer)));
//        echo '<br>';
//    }
//    if (!feof($handle)) {
//        echo "Error: unexpected fgets() fail\n";
//    }
//    fclose($handle);
//}    
    function getWAV($filename){
        list($name,$type) = explode(".", $filename);
        echo "ffmpeg -i "
                .$_SERVER['DOCUMENT_ROOT']."/files/import/".$filename." -vn -ar 16000 -ac 1 -ab 192000 "
                .$_SERVER['DOCUMENT_ROOT']."/files/temp/".$name.".wav";
        PsExecute("ffmpeg -i "
                .$_SERVER['DOCUMENT_ROOT']."/files/import/".$filename." -vn -ar 16000 -ac 1 -ab 192000 "
                .$_SERVER['DOCUMENT_ROOT']."/files/temp/".$name.".wav");
        PsExecute($_SERVER['DOCUMENT_ROOT']."/chronos/chronosBasic "
                .$_SERVER['DOCUMENT_ROOT']."/chronos/lang/RURU RURU-3.0 FAST "
                .$_SERVER['DOCUMENT_ROOT']."/files/temp/".$name.".wav "
                .$_SERVER['DOCUMENT_ROOT']."/files/temp/".$name.".ctm "
                .$_SERVER['DOCUMENT_ROOT']."/files/temp/".$name.".log");
    }
    
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
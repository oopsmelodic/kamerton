<?php
    include '/usr/share/nginx/www/php/conn.php';
    $from = 0;
    $step = 20;
    $length = 60;
    $filepath = $argv[1];
    $filename = $argv[2];
    $streamid= $argv[3];   
    $date = date('mdYhis', time());
    while ($length!=0) {
        exec("nohup ffmpeg -i ".$filepath." -ss ".gmdate("H:i:s",$from)." -t ".gmdate("H:i:s",$step)." -vcodec copy -acodec copy -strict experimental /usr/share/nginx/www/files/import/".$date."_".$streamid.$from.".mp4 &");
        sleep(1);
      $sql = "Insert Into dbfilenames (userid,filename,processed,type,filepath,file_lang,title,length_sec,streamid) ".
              "Values('1','".$date."_".$streamid.$from."','3','mp4','../files/import/".$date."_".$streamid.$from.".mp4','en_GB','".$date."_".$streamid.$from."','0','".$streamid."')";
      mysql_query($sql);     
      $fileid = mysql_insert_id();
  //                        rename($filepath.'video_'.$videoid.'.dat',$filepath.$filename); 
  //                        addTask($fileid,'speech2text','youtube',$url,'loaded'); 
      $sql = "Insert Into dbtasks (type,fileid,urlfrom,fromtype,userid,status) ".
      "Values ('speech2text','".$fileid."','".$filepath."','stream','0','3')";                  
      mysql_query($sql);         
        $from+=$step;
        $length-=$step;   
    }    
?>

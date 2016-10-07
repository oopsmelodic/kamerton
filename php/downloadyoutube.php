<?php
     include '/var/www/main/php/conn.php';
     set_time_limit(0);
//     session_start();
     $id = $argv[1];
     $filepath = $argv[2];
     $fileid = $argv[3];  
     $taskid = $argv[4];
     $type='speech2text';
     $fromtype='youtube';
     $request['type']='';
     $request['title']='';  
            $return=$id;
            $format = 'video/webm'; 
            parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=".$id),$info); 
            $streams = $info['url_encoded_fmt_stream_map']; 
            $streams = explode(',',$streams);
            foreach($streams as $stream){
            parse_str($stream,$data);
            print_r($data);
            if(stripos($data['type'],$format) !== false){ 
                
                $f = get_headers($data['url'].'&amp',1);
                print_r($f);
                if (array_key_exists('Content-Length', $f)){
                    $file_size = intval($f['Content-Length']);
                }else{
                    $file_size = 0;
                }
                $handle = fopen($data['url'].'&amp','rb');
                $handle_local = fopen ($filepath, 'wb+');
                $read_bytes = 0;     
                if(!$handle){
                   $request['type']=101;
                }else
                {                  
                  while(!feof($handle))
                  {                                        
                    $data = fread($handle, 2048);
                    fwrite($handle_local, $data);
                    $read_bytes += 2048;
                  }
#                  fclose($fp);
                  fclose ($handle);
                  fclose($handle_local);
//                  echo '<br>FILESIZ: '. $file_size ;
//                  echo '<br>'. filesize($filepath) .'<br>';
                  if ($file_size === filesize($filepath)){
                        $request['type']=61;              
                        $sql = "Update dbfilenames Set processed='".$request['type']."' Where id='".$fileid."'";
                        mysql_query($sql);     
                        $sql = "Update dbtasks Set status='".$request['type']."' Where id='".$taskid."'";
                        mysql_query($sql);  
                  }else{
                        $request['type']=101;              
                        $sql = "Update dbfilenames Set processed='".$request['type']."' Where id='".$fileid."'";
                        mysql_query($sql);     
                        $sql = "Update dbtasks Set status='".$request['type']."' Where id='".$taskid."'";
                        mysql_query($sql);                     
                  }
                }                         

                }else{
//                    echo '<br>'.'ПОЧЕМУ'.'<br>';
                }
            }
        echo json_encode($request);
?>

<?php

//VALYA EDITION V0.1

//localhost:9990/task=speechtotext&profile=ru&wavFile=c:\src\relay\_workdir_\sample\cnews.wav
//localhost:9990/task=speechtotext&profile=ru&wavFile=c:\_triple\stable\ftp_root\inbox\21.mp3
//localhost:9990/task=phindex&langid=ru_ph&wavFile=c:\_triple\stable\ftp_root\inbox\new.wav
//localhost:9990/phsearch&langid=ru_ph&text=барометр&minScore=0

//VALYA EDITION V0.1
//END
//
//video_10b2cebdd3f941b68b6cf102849de86c

//ЭТО НУЖНО РАСКОМЕНТИТЬ


//  include '/usr/share/nginx/www/php/conn.php';
//  set_time_limit(0);
//  $taskid = $argv[1]; 
//  $filename = $argv[2];
////echo 123;
//  if( $curl = curl_init() ) {
////    $file= file_get_contents('/usr/share/nginx/www/files/temp/11172014014912_10.wav');
//    $fil = "/usr/share/nginx/www/files/temp/".$filename.".wav";
//    $handle = fopen($fil, "r");
////    echo 123;
//    $contents = fread($handle, filesize($fil));
//    fclose($handle);
//    curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddTask&Type=DataToText&Lang=RURU-tel&TempFile='.$filename.'.wav');
//    curl_setopt($curl, CURLOPT_POSTFIELDS,Array("taskdata"=>$contents));
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
//    $out = curl_exec($curl);
//    $p = xml_parser_create();
//    xml_parse_into_struct($p, $out, $vals, $index);
//    xml_parser_free($p);  
////    echo "THIS";
//    $xml=simplexml_load_string($out) or die("Error: Cannot create object");
//    sleep(20);
//    if ($xml!=null){
////        echo 'Action: '. $xml->action.'<br>';
////        echo 'Response: '. $xml->response.'<br>';
////        echo 'Token: '. $xml->responsedata->token.'<br>';
//        if ($xml->action=='ADDTASK' and $xml->response=='SUCCESS'){
//            $token = $xml->responsedata->token;
//            curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=GetStatus&Token='.$token);
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
//            $out = curl_exec($curl);
//            $p = xml_parser_create();
//            xml_parse_into_struct($p, $out, $vals, $index);
//            xml_parser_free($p);  
//            $xml=simplexml_load_string($out) or die("Error: Cannot create object");
//            if ($xml!=null){
////                echo '<pre>';
////                print_r($xml);
////                echo '</pre>'; 
//                if ($xml->responsedata->tasks->status!='ERROR'){
//                    $curl2 = curl_init();
//                    curl_setopt($curl2, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddTask&Type=WavToFmd&File='.$filename.'.wav&Lang=RURU-pm&ResponseFormat=json&Out='.$filename);
//                    curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
//                    $out = curl_exec($curl2); 
//                    $res = json_decode($out,true);             
//                    $request['type']=62;              
//                    $sql = "Update dbtasks Set token='".$token."' ,status='".$request['type']."' Where id='".$taskid."'";
//                    mysql_query($sql);                                         
//                }else{
//                    $sql = "Update dbtasks Set token='".$token."' ,status='61' Where id='".$taskid."'";
//                    mysql_query($sql);    
//                }
//            }else{
//                    $sql = "Update dbtasks Set token='".$token."' ,status='61' Where id='".$taskid."'";
//                    mysql_query($sql);   
//            }
//        }else{
//            $sql = "Update dbtasks Set token='".$token."' ,status='61' Where id='".$taskid."'";
//            mysql_query($sql);               
//        }
//        
//    }
//  }


  
  
  // ТУТ ЖЕСТЬ КАКАЯ ТО ВООБШЕ НЕПОНЯТНАЯ.
  
  
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);//создаём сокет
//socket_bind($socket, '10.153.0.22', 16000) or die('Не удалось соединиться: ');//привязываем его к указанным ip и порту
//socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);//разрешаем использовать один порт для нескольких соединений
//$msg = "\nWelcome to the PHP Test Server. \n" .
//        "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
//    socket_write($socket, $msg, strlen($msg));
//    
//    echo socket_getsockname($socket);;//слушаем сокет
//    
//    //Вторая опция
//    $socket = stream_socket_server("tcp://10.153.0.22:16000", $errno, $errstr) ;
//MTAuOTEuMjAuMjA6MTUwMDA6QUREVEFTSzoxNjU4Mjk0MjUx
//    $fp = fsockopen("tcp://10.153.0.22", 16000, $errno, $errstr);
//    
////    $send = fopen('/usr/share/nginx/www/files/temp/video_e69f6a622ec54988c822b13bd4da248b.wav', 'r');
//    if (!$fp) {
//        echo "ERROR: $errno - $errstr<br />\n";
//    } else {
//        $out = "MTAuOTEuMjAuMjA6MTUwMDA6QUREVEFTSzoxNjU4Mjk0MjUx\r\n";
//        $out .= "0x4D525453\r\n";
//        $out .= "1\r\n";        
//        $out .= "16000Hz\r\n";        
//        $out .= "1\r\n\r\n";        
//       fwrite($fp, '$out');
//        while (!feof($fp)) {
//            $response = fgets($fp, 1024);
//            print(substr($response,9,3));
//        }
//       echo $response;
//       fclose($fp);
////       fclose($send);
//    }

//$url = 'http://10.153.0.30/img/bg1.jpg';
//$tmp = parse_url($url);
// $stream = @fopen($url, 'rb');
//print_r(stream_get_meta_data($stream));

//    $stream = @fsockopen("tcp://10.153.0.22", 16000);;
//    echo "<pre>";
//    print_r(stream_get_meta_data($stream));
//    echo "</pre>";
//        $send = fopen('/usr/share/nginx/www/files/temp/video_e69f6a622ec54988c822b13bd4da248b.wav', 'r');
//        echo "go";
//    if (!$stream) {
//        echo "ERROR: $errno - $errstr<br />\n";
//    } else {
//        $out = "MTAuOTEuMjAuMjA6MTUwMDA6QUREVEFTSzoxNjU4Mjk0MjUx\r\n";
//        $out .= "0x4D525453\r\n";
//        $out .= "1\r\n";        
//        $out .= "16000Hz\r\n";        
//        $out .= "1\r\n\r\n";        
//       fwrite($stream, $out);       
////       stream_copy_to_stream($send, $stream);
//       echo "<br>read";
//        while (!feof($stream)) {
//            $response = fgets($stream, 1024);
//            print(substr($response,9,3));
//        }
//       echo $response;
//       fclose($stream);
//       fclose($send);
//    }

//$file= file_get_contents('/usr/share/nginx/www/files/temp/video_e69f6a622ec54988c822b13bd4da248b.wav');
//error_reporting(E_ALL);
//
//echo "<h2>TCP/IP Connection</h2>\n";
//
///* Get the port for the WWW service. */
//$service_port = 16000;
//
///* Get the IP address for the target host. */
//$address = gethostbyname('10.153.0.22');
//
///* Create a TCP/IP socket. */
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//if ($socket === false) {
//    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
//} else {
//    echo "OK.\n";
//}
//
//echo "Attempting to connect to '$address' on port '$service_port'...";
//$result = socket_connect($socket, $address, $service_port);
//if ($result === false) {
//    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
//} else {
//    echo "OK.\n";
//}
//
//$in = "HEAD / HTTP/1.1\r\n";
//$in .= "token: MTAuOTEuMjAuMjA6MTUwMDA6QUREVEFTSzotOTIxNDEyNzk0\r\n";
//$in .= "Audio Rate: 16000\r\n";
//$in .= "Connection: Close\r\n\r\n";
//$out = '';
//
//echo "Sending HTTP HEAD request...";
//socket_write($socket, $in, strlen($in));
//socket_write($socket, $file, strlen($file));
//echo "OK.\n";
//
//echo "Reading response:\n\n";
//while ($out = socket_read($socket, 2048)) {
//    echo $out;
//}
//
//echo "Closing socket...";
//socket_close($socket);
//echo "OK.\n\n";
  
  
  
  
  //ЭТО РАБОЧАЯ СУЧКА ЕЕ НУЖНО УДАЛИТЬ ПОЛЮБАСУ МЕНЯТЬ ТОЛЬКО ПОТОМ.
  
  
  //VALYA EDITION V0.1

//localhost:9990/task=speechtotext&profile=ru&wavFile=c:\src\relay\_workdir_\sample\cnews.wav
//localhost:9990/task=speechtotext&profile=ru&wavFile=c:\_triple\stable\ftp_root\inbox\21.mp3
//localhost:9990/task=phindex&langid=ru_ph&wavFile=c:\_triple\stable\ftp_root\inbox\new.wav
//localhost:9990/phsearch&langid=ru_ph&text=барометр&minScore=0

//VALYA EDITION V0.1
//END
//
//video_10b2cebdd3f941b68b6cf102849de86c
  include '/var/www/main/php/conn.php';
  set_time_limit(0);
  $taskid = $argv[1]; 
  $filename = $argv[2];
  $file_type = end(explode('/',$argv[3]));
//  $type = $argv[2];
//echo 123;
  if( $curl = curl_init() ) {
    //$file= file_get_contents('/var/www/files/temp/11172014014912_10.wav');
    $fil = "/var/www/main/files/import/".$filename.'.'.$file_type;
    
    $handle = fopen($fil, "r+");
    //echo $file;
    $contents = fread($handle, filesize($fil));
//    echo $contents;
    fclose($handle);
    curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddTask&Type=WorkBitch&Lang=RURU-tel&TempFile='.$filename.'.'.$file_type.'&left=left_'.$filename.'&right=right_'.$filename.'&Out='.$filename);
    curl_setopt($curl, CURLOPT_POSTFIELDS,Array("taskdata"=>$contents));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    $p = xml_parser_create();
    xml_parse_into_struct($p, $out, $vals, $index);
    xml_parser_free($p);  
//    echo "THIS";
    $xml=simplexml_load_string($out) or die("Error: Cannot create object");
    sleep(20);
    if ($xml!=null){
//        echo 'Action: '. $xml->action.'<br>';
//        echo 'Response: '. $xml->response.'<br>';
//        echo 'Token: '. $xml->responsedata->token.'<br>';
        if ($xml->action=='ADDTASK' and $xml->response=='SUCCESS'){
            $token = $xml->responsedata->token;
            curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=GetStatus&Token='.$token);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            $p = xml_parser_create();
            xml_parse_into_struct($p, $out, $vals, $index);
            xml_parser_free($p);  
            $xml=simplexml_load_string($out) or die("Error: Cannot create object");
            if ($xml!=null){
//                echo '<pre>';
//                print_r($xml);
//                echo '</pre>'; 
                if ($xml->responsedata->tasks->status!='ERROR'){
//                    $curl2 = curl_init();
//                    curl_setopt($curl2, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddTask&Type=WavToFmd&File='.$filename.'.'.$file_type.'&Lang=RURU-tel-pm&ResponseFormat=json&Out='.$filename);
//                    curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
//                    $out = curl_exec($curl2); 
//                    $res = json_decode($out,true);             
                    $request['type']=62;              
                    $sql = "Update dbtasks Set token='".$token."' ,status='".$request['type']."' Where id='".$taskid."'";
                    mysql_query($sql);                                                                              
                }else{
                    $sql = "Update dbtasks Set token='".$token."' ,status='61' Where id='".$taskid."'";
                    mysql_query($sql);    
                }
            }else{
                    $sql = "Update dbtasks Set token='".$token."' ,status='61' Where id='".$taskid."'";
                    mysql_query($sql);   
            }
        }else{
            $sql = "Update dbtasks Set token='".$token."' ,status='61' Where id='".$taskid."'";
            mysql_query($sql);               
        }
        
    }
  }


?>

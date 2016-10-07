<?php
//header('Content-Type: text/html; charset=utf-8');
    include '/var/www/main/php/curl.php';
    include '/var/www/main/php/conn.php';
    include '/var/www/main/php/myFunct.php';
//    ini_set("display_errors",1);
    $userid = $argv[1];
    $taskid = $argv[2];
    $data1 = '';    
    $data2 = $argv[3];    
//    $userid = 7;
//    $taskid = 148;
//    $data1 = '';    
//    $data2 = 75;    
    $curl = curl_init();
//    $filename = 'video_b6d2ade975d288eab737187cfb001087';
//    $listexample=Array('путин','россия'); 
    $sql = "Select * From dbtasks Where id='".$taskid."'";
    $result = mysql_query($sql);
    if ($result){            
            while ($row = mysql_fetch_array($result)) {
                $data1=$row['data1'];
                $fileid=$row['fileid'];
            }
    }
    $listexample =  explode('|', $data1);
//    echo $fileid.'<1><><><><><>';
    if ($fileid>0){
        $sql = "Select * From dbfilenames Where id='".$fileid."'";
    }else{
        $sql = "Select * From dbfilenames Where userid='".$userid."'";
    }
    $results = mysql_query($sql);
    echo '<br>Start<br>';
    if ($results){            
        echo '<br>CatchUserID<br>';
            while ($row = mysql_fetch_array($results)) {
                $filename = $row['filename'];
                curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=DelList&Key='.$filename);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_exec($curl);    
                curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddList&Key='.$filename.'&ResponseFormat=json');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                $out = curl_exec($curl); 
                $res = json_decode($out,true);
                echo '<pre>1234';
                print_r($listexample);
                echo '</pre>';                
                if ($res['autnresponse']['action']['$']=="ADDLIST" && $res['autnresponse']['response']['$']=="SUCCESS" ){ 
                    foreach ($listexample as $value) {
                        curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddListLine&Key='.$filename.'&Line='.$value);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                        curl_exec($curl);                        
                    }
                    curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddTask&Type=SearchFMD&File='.$filename.'.fmd&PhraseList=ListManager/'.$filename.'&Out=fonem_'.$filename.'.ctm&Lang=RURU-pm&ResponseFormat=json');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                    $out = curl_exec($curl);  
                    $result = json_decode($out,true);                    
                    echo '<pre>';
                    print_r($result);
                    echo '</pre>';                     
                    sleep(10);
                    if ($result['autnresponse']['action']['$']=="ADDTASK" && $result['autnresponse']['response']['$']=="SUCCESS" ){
                        $token=$result['autnresponse']['responsedata']['token']['$'];
                        $res =sendRequestCurl('GetStatus', $token);
//                        do {
                            if ($res['autnresponse']['responsedata']['tasks']['task']['status']['$']=='FINISHED'){
                                $res =sendRequestCurl('GetResults', $token); 
                                $db='';
                                echo '<pre>123123213';
                                print_r($res);
                                echo '</pre><br>'; 
                                foreach ($res['autnresponse']['responsedata']['stt_transcript']['stt_record'] as $value) {
                                    $score = $value['score']['$']*100;  
                                    $time = $value['start']['$']-1;
                                    if ($score>=$data2 and $value["label"]["$"]!='<s>'){
                                        $data = 'Найденно слово "'.$value["label"]["$"].'" в файле "'.$row["title"].'", c вероятностью '.$score.'%.';
                                        $sql = "Insert Into dbmsg (fileid,msg,fromid,toid,status,del,timestart) Values('".$row['id']."','".$data."','0','".$userid."','0','0','".$time."')";
                                        mysql_query($sql);
                                        $db.=$data.'<br>';
                                    }
                                }
                                $sql = "Update dbtasks Set status='4' Where id='".$taskid."'";
                                mysql_query($sql); 
                                try {
    //                                sendmail('Фонемный поиск', $db);
                                } catch (Exception $exc) {
                                    echo $exc->getTraceAsString();
                                }
                            }else{
                                $sql = "Update dbtasks Set status='80' Where id='".$taskid."'";
                                mysql_query($sql);                             
                            }
//                        } while ($res['autnresponse']['responsedata']['tasks']['task']['status']['$']=='PROCESSING');
                    }else{
                        $sql = "Update dbtasks Set status='80' Where id='".$taskid."'";
                        mysql_query($sql);   
                    }

                }           
            }
            curl_close($curl);
    }else{
        $sql = "Update dbtasks Set status='80' Where id='".$taskid."'";
        mysql_query($sql);          
    }
    
    
//    function sendmail($subject,$body){
//        try {
//            require("/usr/share/nginx/www/php/class/class.phpmailer.php");
//            $mail = new PHPMailer();
//            $mail->CharSet = "UTF-8";
//            $mail->IsSMTP();
//            $mail->Host = "smtp.mail.ru";
//            $mail->Port = 25;
//            $mail->SMTPDebug  = 0;
//            $mail->SMTPAuth = true; 
//            $mail->SMTPSecure = "tls";
//            $mail->Username = "oops.melodic@mail.ru";  
//            $mail->Password = "9293709b13537235"; 
//            $mail->SetFrom('oops.melodic@mail.ru', 'Фонемный поиск');
//            $mail->AddAddress('o.fedotov@in-line.ru');
//            $mail->IsHTML(true);
//            $mail->Subject = $subject;
//            $mail->Body    = $body;
//            return $mail->Send();            
//        } catch (Exception $exc) {
//            return;
//        }
//
//
//   }
?>

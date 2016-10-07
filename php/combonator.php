<?php
//header('Content-Type: text/html; charset=utf-8');
    include '/var/www/main/php/curl.php';
    include '/var/www/main/php/conn.php';
    include '/var/www/main/php/myFunct.php';
//    ini_set("display_errors",1);
    $userid = 15;
//    $data1 = 'договор'; 
//    $data2 = $argv[3];    
//    $userid = 7;
//    $taskid = 148;
//    $data1 = '';    
//    $data2 = 75;    
    $curl = curl_init();
//    $filename = 'video_b6d2ade975d288eab737187cfb001087';
//    $listexample=Array('путин','россия'); 

//    echo $fileid.'<1><><><><><>';
//    if ($fileid>0){
//        $sql = "Select * From dbfilenames Where id='".$fileid."'";
//    }else{

    echo '<br>Start<br>';
    
    curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=DelList&Key='.'combine'.$userid);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_exec($curl);    
    curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddList&Key='.'combine'.$userid.'&ResponseFormat=json');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl); 
    $res = json_decode($out,true);                    
    echo '<pre>';
    print_r($res);
    echo '</pre>';      
    $sql = "Select * From dbfilenames Where userid='".$userid."'";
    $results = mysql_query($sql);    
    if ($results){            
        echo '<br>CatchUserID<br>';
            while ($row = mysql_fetch_array($results)) {
                $filename = $row['filename'];           
                curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddListLine&Key='.'combine'.$userid.'&Line='.$filename.';'.$filename.'.fmd');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_exec($curl);                      
            }
            curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddTask&Type=CombineFMD&ListFile=ListManager/'.'combine'.$userid.'&FileOut=combine'.$userid.'&ResponseFormat=json');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);   
            $result = json_decode($out,true);                    
            echo '<pre>';
            print_r($result);
            echo '</pre>';                    
            curl_close($curl);
    }else{
//        $sql = "Update dbtasks Set status='80' Where id='".$taskid."'";
//        mysql_query($sql);          
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

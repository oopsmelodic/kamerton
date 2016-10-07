<?php
//    ini_set('display_errors', 1);
  include '/var/www/main/php/conn.php';
//  $fileid = '1134';
//  $filename = 'video_e2fc63d9f4a00394fd11c69f3bc2affb';   
//  $taskid = '1664';
//  $token = 'MTAuOTEuMjAuMjA6MTUwMDA6QUREVEFTSzotMTcyOTYxODc5';
  $data['server'] = null;
  $data['database'] = null;
  $data['tokens'] = null;
  session_start();
  if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/?action=QueueInfo&queueAction=GetStatus&maxResults=100&queueName=ADDTASK&responseformat=json');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = json_decode(curl_exec($curl),true);  
    if($out['autnresponse']['response']['$']=="SUCCESS"){
        $data['server'] = $out['autnresponse']['responsedata']['actions']['action'];
        $sql = "Select dt.urlfrom,dt.type,dt.token,dt.fileid ,df.id, dt.userid, df.title, df.length_record From dbtasks as dt Left Join dbfilenames as df on dt.fileid=df.id Where dt.userid='".$_SESSION['user']['id']."' LIMIT 1000";
        $result = mysql_query($sql);
        if ($result) {
           while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {    
//               echo "<pre>";
//               print_r($row);
//               echo "</pre>";
               $data['database'][]=$row;
               $data['tokens'][]=$row['token'];
           }
        }     
        echo json_encode($data);
    }
  }
                
?>

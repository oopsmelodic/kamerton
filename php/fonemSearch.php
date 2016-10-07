<?php
//header("Content-type: application/json");
ini_set("display_errors",1);   
    session_start();
    include './curl.php';
    include './conn.php';
//    include './myFunct.php';
    $mass = null;
//    $userid = 7;
//    $data1 = 'договор';    
    $userid = $_SESSION['user']['id'];
    $data1 = $_GET['phrase'];    
    $data2 = 60;   
    $curl = curl_init();
//    $sql = "Select * From dbfilenames Where userid='".$userid."'";
//    $results = mysql_query($sql);
//    if ($results){         
//            $mass[]='';
//            while ($row = mysql_fetch_array($results)) {        
            curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=AddTask&Type=SearchFMD&File=combine'.$userid.'.fmd&Phrase='.$data1.'&Lang=RURU-pm&ResponseFormat=json');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);  
            $result = json_decode($out,true);                                    
                if ($result['autnresponse']['action']['$']=="ADDTASK" && $result['autnresponse']['response']['$']=="SUCCESS" ){
                    $token=$result['autnresponse']['responsedata']['token']['$'];
                    do {   
                        usleep(300);
                        $res1 =sendRequestCurl('GetStatus', $token);
//                                
//                            do {
                            if ($res1['autnresponse']['responsedata']['tasks']['task']['status']['$']=='FINISHED'){
                                $res =sendRequestCurl('GetResults', $token); 
                                $db='';
                                foreach ($res['autnresponse']['responsedata']['stt_transcript']['stt_record'] as $value) {
                                    $score = $value['score']['$']*100;  
//                                    $time = $value['start']['$']-1;
                                    if ($score>=$data2 and $value["label"]["$"]!='<s>'){
                                        $sql='Select * From dbfilenames Where filename="'.$value["id"]["$"].'"';
//                                        echo $sql;
                                        $mysql_res = mysql_query($sql);
                                        if ($mysql_res) {
                                            $mysql_row = mysql_fetch_array($mysql_res);
//                                            echo '<pre>';
//                                            print_r($mysql_row);
//                                            echo '</pre>';                                           
                                            $mass[]=Array('id'=>$mysql_row['id'],'value'=>$value["label"]["$"],'time'=>$value['start']['$'],'score'=>$value["score"]["$"],'title'=>$mysql_row['title'],'path'=>  str_replace('..', '', $mysql_row['filepath']),'type'=>$mysql_row['type']);
//                                                $data = 'Найденно слово "'.$value["label"]["$"].'" в файле "'.$row["title"].'", c вероятностью '.$score.'%.';
//                                                $sql = "Insert Into dbmsg (fileid,msg,fromid,toid,status,del,timestart) Values('".$row['id']."','".$data."','0','".$userid."','0','0','".$time."')";
//                                                mysql_query($sql);                                                    
                                        }                                                                                     
                                    }
                                }                                        
                                try {
//                                                $sql = "Insert Into dbmsg (fileid,msg,fromid,toid,status,del,timestart) Values('".$row['id']."','Отпровляем на сервер сообшения','0','".$userid."','0','0','".$time."')";
//                                                mysql_query($sql);                                                                                      
                                } catch (Exception $exc) {
//                                    echo $exc->getTraceAsString();
                                }
                            }
                    } while ($res1['autnresponse']['responsedata']['tasks']['task']['status']['$']!='FINISHED');
                }
//                    } while ($result['autnresponse']['action']['$']=="ADDTASK" && $result['autnresponse']['response']['$']!="SUCCESS" or $result['autnresponse']['action']['$']=="ADDTASK" && $result['autnresponse']['response']['$']!="ERROR" );

//                }     
        if (!is_null($mass)){            
            echo json_encode($mass);
        }else{
            $mass[]=Array('status'=>'error','id'=>'','value'=>'Поиск не дал результатов.','time'=>'','score'=>'');
            echo json_encode($mass); 
        }            
//            }
            curl_close($curl);
    
    
?>

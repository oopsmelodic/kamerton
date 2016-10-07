<?php
  include '/var/www/main/php/conn.php';
  set_time_limit(0);
  $fileid = $argv[1];
  $filename = $argv[2];   
  $taskid = $argv[3];
  $token = $argv[4];
  if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=GetStatus&Token='.$token);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);  
    $p = xml_parser_create();
    xml_parse_into_struct($p, $out, $vals, $index);
    xml_parser_free($p);  
    $xml=simplexml_load_string($out) or die("Error: Cannot create object");    
//        echo "<pre>";
//        print_r($xml);
//        echo "</pre>"; 
    if ($xml->response=="SUCESS"){
        curl_setopt($curl, CURLOPT_URL, 'http://10.153.0.22:15000/action=GetResults&Token='.$token);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $out = curl_exec($curl);
        $p = xml_parser_create();
        xml_parse_into_struct($p, $out, $vals, $index);
        xml_parser_free($p);  
        $xml=simplexml_load_string($out) or die("Error: Cannot create object");
        if ($xml!=null){        
            $arr=xml2array($xml->responsedata->stt_transcript);
    //        echo "<pre>";
    //        print_r($xml);
    //        echo "</pre>";
            if ($xml!=null){

                foreach ($arr['stt_record'] as $value) {
                    $val = str_replace('<s>', '.', $value->label);
                    $val = str_replace('<SIL>', '...', $val);
                    $start=xml2array($value->start);
                    $end=xml2array($value->end);
                    $mass[]=array('timestart'=>$start[0],
                                  'timeend'=>$end[0],
                                  'value'=>$val);

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
//                echo "<pre>";
//                print_r($db);
//                echo "</pre>";            
            }
        }
    }
  }
  
  
  function xml2array ( $xmlObject, $out = array () )
        {
            foreach ( (array) $xmlObject as $index => $node )
                $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

            return $out;
        }
?>

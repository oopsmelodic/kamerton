<?php 
  function sendRequestCurl($action,$token,$data='',$lang='RURU',$responseformat='json',$host='10.153.0.22',$port='15000'){
      $out = "";
      if( $curl = curl_init() ) {  
            curl_setopt($curl, CURLOPT_URL, 'http://'.$host.':'.$port.'/action='.$action.'&ResponseFormat='.$responseformat.'&Token='.$token);
//            echo 'http://'.$host.':'.$port.'/action='.$action.'&ResponseFormat='.$responseformat.'&Token='.$token;
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $res =curl_exec($curl); 
            return json_decode($res,true); 
      }
  } 
?>
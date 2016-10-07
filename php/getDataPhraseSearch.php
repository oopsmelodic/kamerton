<?php
    include '/var/www/main/php/curl.php';
    set_time_limit(0);
    $token='';
    $results = sendRequestCurl('GetStatus', $token);
    if ($results['responsedata']['tasks']['task']['status']['$']=="FINISHED"){
        $results = sendRequestCurl('GetResults', $token);
        
   }
?>

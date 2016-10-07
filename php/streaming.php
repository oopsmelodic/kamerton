<?php

$cfg['player_host'] = "10.153.0.30";
$cfg['player_port'] = "8080";
$cfg['player_pass'] = "";
//$stream_url = "http://185.5.40.102:1000/udp/239.65.40.1:5001";
//$stream_dst="0.0.0.0:8081/stream_469f2d7c3de89125cd996add184e6f5c.ogg";
//$stream_name="stream_469f2d7c3de89125cd996add184e6f5c";
//vlc_cmd_addstream($stream_name,$stream_url,$stream_dst);
//    echo("<pre>" . vlc_status('pl_play') . "</pre>");

function vlc_status($command) {
    global $cfg;
    $request  = 'GET /requests/status.xml?command=' . $command . ' HTTP/1.1' . "\r\n";
    $request .= 'Host: ' . $cfg['player_host'] . ':' . $cfg['player_port'] . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    $request .= 'Authorization: Basic ' . base64_encode(':' . $cfg['player_pass']) . "\r\n\r\n";
    
    $soket = @fsockopen($cfg['player_host'], $cfg['player_port'], $error_no, $error_string, 1) or die();
    @fwrite($soket, $request) or die();
    $content = stream_get_contents($soket);
    fclose($soket);
	
    $temp = explode("\r\n\r\n", $content, 2);
    if (isset($temp[1])) {
        $header = $temp[0];
        $content = $temp[1];
    }
            
    return $content;
}

function vlc_cmd_addstream($name,$url,$dst) {
    global $cfg;
    $cmd = 'new '.$name.' broadcast enabled input '.$url.' output #transcode{vcodec=theo,vb=768,fps=25,scale=1,acodec=vorb,ab=128,samplerate=44100,channels=2}:std{access=http,mux=ogg,dst='.$dst.'}';
    $request  = 'GET /requests/vlm_cmd.xml?command=' . rawurlencode($cmd) . ' HTTP/1.1' . "\r\n";
    $request .= 'Host: ' . $cfg['player_host'] . ':' . $cfg['player_port'] . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    $request .= 'Authorization: Basic ' . base64_encode(':' . $cfg['player_pass']) . "\r\n\r\n";
    
    $soket = @fsockopen($cfg['player_host'], $cfg['player_port'], $error_no, $error_string, 1) or die();
    @fwrite($soket, $request) or die();
    $content = stream_get_contents($soket);
    fclose($soket);
	
    
    $temp = explode("\r\n\r\n", $content, 2);
    if (isset($temp[1])) {
        $header = $temp[0];
        $content = $temp[1];
    }
    vlc_cmd_play($name);
    return $content;
}

function vlc_cmd_play($name) {
    global $cfg;
    $cmd = 'control '.$name.' play';
    $request  = 'GET /requests/vlm_cmd.xml?command=' . rawurlencode($cmd) . ' HTTP/1.1' . "\r\n";
    $request .= 'Host: ' . $cfg['player_host'] . ':' . $cfg['player_port'] . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    $request .= 'Authorization: Basic ' . base64_encode(':' . $cfg['player_pass']) . "\r\n\r\n";
    
    $soket = @fsockopen($cfg['player_host'], $cfg['player_port'], $error_no, $error_string, 1) or die();
    @fwrite($soket, $request) or die();
    $content = stream_get_contents($soket);
    fclose($soket);
	
    $temp = explode("\r\n\r\n", $content, 2);
    if (isset($temp[1])) {
        $header = $temp[0];
        $content = $temp[1];
    }
    
    return $content;
}

function vlc_cmd_stop($name) {
    global $cfg;
    $cmd = 'control '.$name.' stop';
    $request  = 'GET /requests/vlm_cmd.xml?command=' . rawurlencode($cmd) . ' HTTP/1.1' . "\r\n";
    $request .= 'Host: ' . $cfg['player_host'] . ':' . $cfg['player_port'] . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    $request .= 'Authorization: Basic ' . base64_encode(':' . $cfg['player_pass']) . "\r\n\r\n";
    
    $soket = @fsockopen($cfg['player_host'], $cfg['player_port'], $error_no, $error_string, 1) or die();
    @fwrite($soket, $request) or die();
    $content = stream_get_contents($soket);
    fclose($soket);
	
    $temp = explode("\r\n\r\n", $content, 2);
    if (isset($temp[1])) {
        $header = $temp[0];
        $content = $temp[1];
    }
    
    return $content;
}

function vlc_del_all() {
    global $cfg;
    $cmd = 'del all';
    $request  = 'GET /requests/vlm_cmd.xml?command=' . rawurlencode($cmd) . ' HTTP/1.1' . "\r\n";
    $request .= 'Host: ' . $cfg['player_host'] . ':' . $cfg['player_port'] . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    $request .= 'Authorization: Basic ' . base64_encode(':' . $cfg['player_pass']) . "\r\n\r\n";
    
    $soket = @fsockopen($cfg['player_host'], $cfg['player_port'], $error_no, $error_string, 1) or die();
    @fwrite($soket, $request) or die();
    $content = stream_get_contents($soket);
    fclose($soket);
	
    $temp = explode("\r\n\r\n", $content, 2);
    if (isset($temp[1])) {
        $header = $temp[0];
        $content = $temp[1];
    }
    
    return $content;
}

function vlc_view_streams(){
    global $cfg;
    $request  = 'GET /requests/vlm.xml HTTP/1.1' . "\r\n";
    $request .= 'Host: ' . $cfg['player_host'] . ':' . $cfg['player_port'] . "\r\n";
    $request .= 'Connection: Close' . "\r\n";
    $request .= 'Authorization: Basic ' . base64_encode(':' . $cfg['player_pass']) . "\r\n\r\n";
    
    $soket = @fsockopen($cfg['player_host'], $cfg['player_port'], $error_no, $error_string, 1) or die();
    @fwrite($soket, $request) or die();
    $content = stream_get_contents($soket);
    fclose($soket);
	
    $temp = explode("\r\n\r\n", $content, 2);
    if (isset($temp[1])) {
        $header = $temp[0];
        $content = $temp[1];
    }
    $xmlparser = xml_parser_create();
    xml_parse_into_struct($xmlparser,$content,$values);
    $i=1;
    foreach ($values as $key => $value) {
        switch ($value['tag']) {
            case 'BROADCAST':
                  if ($value['type']=='open'){
                      $mass['name']=$value['attributes']['NAME'];
                      $mass['enabled']=$value['attributes']['ENABLED'];
                  }
                  if ($value['type']=='close'){
                      $mass['parentid']=0;
                      $mass['isgroup']=0;
                      $mass['id']=$i;
                      $i++;
                      $db[]=$mass;
                  }

                break;
            case 'INPUT':
                  if ($value['type']=='complete'){
                      $mass['input_url']=$value['value'];
                  }
                break;
            case 'OUTPUT':
                  if ($value['type']=='complete'){
                      $mass['type']= end(explode('=',substr($value['value'], strpos($value['value'], 'access='),  strpos($value['value'], ',mux')-  strlen($value['value']))));
                  }
            case 'INSTANCE':
                  if ($value['type']=='complete'){
                      $mass['state']=$value['attributes']['STATE'];                   
                  }
                break;                
            default:
                break;
        }
    }   
    return $db;    
}

?>

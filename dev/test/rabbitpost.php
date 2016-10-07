<form name="form1" action="" method="get">
    <input name="lol">
    <button type="submit">БУТТН</button>
</form>

<?php


    ini_set('display_errors', 1);
//    phpinfo();
    if (isset($_GET['lol'])){
        echo $_GET['lol'];
        $rabbit = new AMQPConnection(array('host' => '127.0.0.1', 'port' => '5672', 'login' => 'guest', 'password' => 'guest'));
        $rabbit->connect();

        $testChannel = new AMQPChannel($rabbit);
        $testExchange = new AMQPExchange($testChannel);
        $msg = Array('msg'=>stripslashes($_GET['lol'])
                    ,'from'=>'host'
                    ,'agent'=>$_SERVER['HTTP_USER_AGENT']
                    ,'type'=>'to_speech'
                    ,'taskdata'=>Array('action'=>'getResults',
                                        'token'=>'token_id',
                                        'lang'=>'RURU-tel',
                                        'file_path'=>'/var/www/main/files/import/video_34ce9e3c6dd9a6581789a74cffec5c91.webm'));
//        $testExchange->setName('amq.direct');
        $testExchange->publish(json_encode($msg, true), 'to_work');

        $rabbit->disconnect();
    }
<?php
ini_set('display_errors', 1);

$rabbit = new AMQPConnection(array('host' => '127.0.0.1', 'port' => '5672', 'login' => 'guest', 'password' => 'guest'));
$rabbit->connect();

$channel = new AMQPChannel($rabbit);

$q = new AMQPQueue($channel);
$q->setName('from_worker');
$q->declare();
$q->bind('amq.direct', 'test1');

while ($envelope = $q->get()){
    
    if ($envelope) {
        echo '<pre>';
        print_r($envelope);
        echo '</pre>';
        $q->ack($envelope->getDeliveryTag());
    }
}

$rabbit->disconnect();
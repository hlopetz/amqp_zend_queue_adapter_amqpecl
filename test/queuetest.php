<?php
require_once('zfbootstrap.php');

function sendMessages($queue)
{
    // Get number of messages in a queue (supports Countable interface from SPL)
    echo "Pre send Message Count: " . count($queue) . PHP_EOL;

    for ($j = 1; $j <=5; $j++){
        $message = "Stuff-$j";
        $queue->send($message);
    }
    // Get number of messages in a queue (supports Countable interface from SPL)
    echo "Post send Message Count: " . count($queue) . PHP_EOL;
}

function getMessages($queue)
{
    // Get number of messages in a queue (supports Countable interface from SPL)
    echo "Pre recieve Message Count: " . count($queue) . PHP_EOL;

    // Get up to 5 messages from a queue
    $messages = $queue->receive(5);

    foreach ($messages as $i => $message) {
        echo $message->body, "\n";

        // We have processed the message; now we remove it from the queue.
        $queue->deleteMessage($message);
    }

    // Get number of messages in a queue (supports Countable interface from SPL)
    echo "Post recieve Message Count: " . count($queue) . PHP_EOL;
}

$options = array( 
    'name' => 'queue1',
);

echo "Testing Array Queue" . PHP_EOL;
$queue = new Zend_Queue('Array',$options);

sendMessages($queue);
getMessages($queue);

echo "Testing AMQP Queue" . PHP_EOL;
require_once('AMQP.php');
$options = array( 
    'name' => 'ZendTest',
    'driverOptions' => array(
        'host' => 'localhost',
    ),
);
$amqp_adapter = new AMQP_Queue_Adapter($options);
$amqp_queue = new Zend_Queue($amqp_adapter, $options);

getMessages($amqp_queue);
sendMessages($amqp_queue);
getMessages($amqp_queue);

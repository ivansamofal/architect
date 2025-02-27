<?php

require 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$conn = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

try {
    $conn->channel();
    echo "✅ Successfully connected to RabbitMQ!";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
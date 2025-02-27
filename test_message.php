<?php

require 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$conn = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $conn->channel();

try {
    // Открытие канала
    $channel->queue_declare('books_queue', false, true, false, false);  // создаем очередь, если ее нет

    // Создание сообщения
    $msg = new AMQPMessage('Hello, RabbitMQ!');

    // Отправка сообщения в очередь
    $channel->basic_publish($msg, '', 'books_queue'); // Отправляем в очередь с именем 'test_queue'

    echo "✅ Message sent to queue 'test_queue'!";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
} finally {
    // Закрытие канала и соединения
    $channel->close();
    $conn->close();
}

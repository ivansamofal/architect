<?php
require 'vendor/autoload.php';
require 'generated/Calculations/Calculations_pb.php';
require 'generated/Calculations/CalculationServiceClient.php';

use Calculations\CalculationServiceClient;
use Calculations\CalculationRequest;

$client = new CalculationServiceClient('109.196.164.36:8080', [
    'credentials' => \Grpc\ChannelCredentials::createInsecure(),
]);

$request = new CalculationRequest();
// Заполните поля запроса, если требуется

list($response, $status) = $client->GetCalculations($request)->wait();

if ($status->code !== \Grpc\STATUS_OK) {
    echo "Ошибка: " . $status->details . "\n";
} else {
    // Обработка ответа
    $calculations = $response->getCalculations();
    print_r($calculations);
}

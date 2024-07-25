<?php

require 'vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

$host = '172.20.0.4'; // Use the broker's Docker IP
$port = 1883;
$clientId = 'test_flow';
$username = 'equipa1';
$password = 'equipa1';
$topic = 'flowtopic';
$message = '87'; // Test interval time

$mqtt = new MqttClient($host, $port, $clientId);
$connectionSettings = (new ConnectionSettings)
    ->setUsername($username)
    ->setPassword($password)
    ->setKeepAliveInterval(60);

try {
    $mqtt->connect($connectionSettings, true);
    echo "Connected to MQTT broker\n";
    $mqtt->publish($topic, $message, 0);
    echo "Message published: $message\n";
    $mqtt->disconnect();
} catch (\Exception $e) {
    echo 'Failed to publish message: ' . $e->getMessage() . "\n";
}
<?php

use Aws\CloudWatch\CloudWatchClient;
use pmill\RabbitRabbit\Conditions\GreaterThan;
use pmill\RabbitRabbit\ConsumerManager;
use pmill\RabbitRabbit\RabbitConfig;
use pmill\RabbitRabbitCloudWatch\CloudWatchRule;

require __DIR__ . '/../vendor/autoload.php';

$config = new RabbitConfig([
    'baseUrl' => 'localhost:15672',
    'username' => 'guest',
    'password' => 'guest',
]);

$manager = new ConsumerManager($config);

$vhostName = '/';
$queueName = 'messages';

$cloudWatchClient = new CloudWatchClient([
    'version' => 'latest',
    'region' => 'eu-west-1',
    'credentials' => [
        'key' => '',
        'secret' => '',
    ],
]);

$manager->addRule(
    new CloudWatchRule(
        $vhostName,
        $queueName,
        $cloudWatchClient,
        'queue_:queueName'
    ),
    new GreaterThan(0, true)
);

$manager->run();

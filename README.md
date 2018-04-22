# pmill/rabbit-rabbit-cloudwatch

## Introduction

This library is an integration for [pmill/rabbit-rabbit](https://github.com/pmill/rabbit-rabbit) allows you to send RabbitMQ
queue counts as CloudWatch metrics when the queue counts match conditions.

## Requirements

This library package requires PHP 7.1 or later, and AWS credentials that give you permission to put CLoudWatch metric 
data (cloudwatch:PutMetricData).

## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest version:

```bash
composer require pmill/rabbit-rabbit-cloudwatch
```

# Usage

The following example send the current queue count as a metric to Amazon CloudWatch.

```php
$config = new RabbitConfig([
    'baseUrl' => 'localhost:15672',
    'username' => 'guest',
    'password' => 'guest',
]);

$manager = new ConsumerManager($config);

$vhostName = '/';
$queueName = 'messages';
$metricName = 'queue_:queueName';

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
        $metricName
    ),
    new GreaterThan(0)
);

$manager->run();
```

# Version History

0.1.0 (22/04/2018)

*   First public release of rabbit-rabbit-cloudwatch


# Copyright

pmill/rabbit-rabbit-cloudwatch
Copyright (c) 2018 pmill (dev.pmill@gmail.com) 
All rights reserved.
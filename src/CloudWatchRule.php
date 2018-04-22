<?php
namespace pmill\RabbitRabbitCloudWatch;

use Aws\CloudWatch\CloudWatchClient;
use pmill\RabbitRabbit\AbstractRule;

class CloudWatchRule extends AbstractRule
{
    /**
     * @var CloudWatchClient
     */
    protected $cloudWatchClient;

    /**
     * @var string
     */
    protected $metricName;

    /**
     * EcsRule constructor.
     *
     * @param string $vHostName
     * @param string $queueName
     * @param CloudWatchClient $cloudWatchClient
     * @param string $metricName
     */
    public function __construct(
        string $vHostName,
        string $queueName,
        CloudWatchClient $cloudWatchClient,
        string $metricName
    ) {
        $this->cloudWatchClient = $cloudWatchClient;
        $this->metricName = $metricName;

        parent::__construct($vHostName, $queueName);
    }

    /**
     * @param int $readyMessageCount
     */
    public function run(int $readyMessageCount): void
    {
        $metricName = $this->metricName;
        $metricName = str_replace(':queueName', $this->queueName, $metricName);
        $metricName = str_replace(':vhostName', $this->vHostName, $metricName);

        $this->cloudWatchClient->putMetricData(array(
            'Namespace' => 'string',
            'MetricData' => array(
                array(
                    'MetricName' => $metricName,
                    'Timestamp' => time(),
                    'Value' => $readyMessageCount,
                    'Unit' => 'Count'
                )
            )
        ));
    }
}

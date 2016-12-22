<?php
require_once(__DIR__ . '/../vendor/autoload.php');

$settings = require(__DIR__ . '/settings.php');

$api_instance = new Swagger\Client\Api\DefaultApi();
$body = new \Swagger\Client\Model\SearchModel($settings);

try {
    $result = $api_instance->searchDocuments($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->searchDocuments: ', $e->getMessage(), PHP_EOL;
}

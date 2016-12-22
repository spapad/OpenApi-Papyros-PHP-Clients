<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\IdApi();
$body = new \Swagger\Client\Model\Protocolin(); // \Swagger\Client\Model\Protocolin | Document Metadata

try {
    $result = $api_instance->postProtocol($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling IdApi->postProtocol: ', $e->getMessage(), PHP_EOL;
}

<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\DefaultApi();
$body = new \Swagger\Client\Model\Credentials(); // \Swagger\Client\Model\Credentials | Credentials

try {
    $result = $api_instance->pauth($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->pauth: ', $e->getMessage(), PHP_EOL;
}

<?php
require_once(__DIR__ . '/../vendor/autoload.php');

$settings = require(__DIR__ . '/settings.php');

$api_instance = new Swagger\Client\Api\DefaultApi();
$body = new \Swagger\Client\Model\Credentials($settings);

try {
    $result = $api_instance->pauth($body);
    echo "Το API key είναι: ", $result->getApiKey();
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->pauth: ', $e->getMessage(), PHP_EOL;
}

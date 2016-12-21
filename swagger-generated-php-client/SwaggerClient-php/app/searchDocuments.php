<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\DefaultApi();
$body = new \Swagger\Client\Model\SearchModel(); // \Swagger\Client\Model\SearchModel | 

try {
    $result = $api_instance->seacrhDocuments($body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->seacrhDocuments: ', $e->getMessage(), PHP_EOL;
}

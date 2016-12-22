<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\DefaultApi();
$doc_id = "doc_id_example"; // string | 

try {
    $result = $api_instance->getPdf($doc_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->getPdf: ', $e->getMessage(), PHP_EOL;
}

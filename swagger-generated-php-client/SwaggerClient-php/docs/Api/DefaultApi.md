# Swagger\Client\DefaultApi

All URIs are relative to *https://protocoltest.minedu.gov.gr:443/openpapyros/api*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getDocData**](DefaultApi.md#getDocData) | **GET** /document/data/{docId} | Επιστροφή των δεδομένων με τα οποία έχει αρχειοθετηθεί ένα έγγραφο
[**getPdf**](DefaultApi.md#getPdf) | **GET** /document/pdf/{docId} | Επιστρέφει το έγγραφο που έχει ζητηθεί με το Id του σε μορφή Base64 encoded String
[**pauth**](DefaultApi.md#pauth) | **PUT** /pauthenticate/pauth | Αυθεντικοποίηση του χρήστη και επιστροφή ενός Api Key με το οποίο ο χρήστης μπορεί να προχωρήσει στις υπηρεσιες του Api θέτοτας το κλειδί σαν Header του Api ώς \&quot;Api_Key\&quot;
[**seacrhDocuments**](DefaultApi.md#seacrhDocuments) | **POST** /search/documents | Επιστροφή ενός Array με στοιχεία τους αριθμούς του πρωτοκόλλου που ανταποκρίνονται στα σοιχεία της αναήτησης


# **getDocData**
> \Swagger\Client\Model\DocumentDataDto getDocData($doc_id)

Επιστροφή των δεδομένων με τα οποία έχει αρχειοθετηθεί ένα έγγραφο



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\DefaultApi();
$doc_id = "doc_id_example"; // string | 

try {
    $result = $api_instance->getDocData($doc_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->getDocData: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **doc_id** | **string**|  |

### Return type

[**\Swagger\Client\Model\DocumentDataDto**](../Model/DocumentDataDto.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getPdf**
> \Swagger\Client\Model\DocumentDto getPdf($doc_id)

Επιστρέφει το έγγραφο που έχει ζητηθεί με το Id του σε μορφή Base64 encoded String



### Example
```php
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
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **doc_id** | **string**|  |

### Return type

[**\Swagger\Client\Model\DocumentDto**](../Model/DocumentDto.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **pauth**
> \Swagger\Client\Model\ApiKey pauth($body)

Αυθεντικοποίηση του χρήστη και επιστροφή ενός Api Key με το οποίο ο χρήστης μπορεί να προχωρήσει στις υπηρεσιες του Api θέτοτας το κλειδί σαν Header του Api ώς \"Api_Key\"



### Example
```php
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
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\Credentials**](../Model/\Swagger\Client\Model\Credentials.md)| Credentials |

### Return type

[**\Swagger\Client\Model\ApiKey**](../Model/ApiKey.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **seacrhDocuments**
> \Swagger\Client\Model\ProtocolNumber[] seacrhDocuments($body)

Επιστροφή ενός Array με στοιχεία τους αριθμούς του πρωτοκόλλου που ανταποκρίνονται στα σοιχεία της αναήτησης



### Example
```php
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
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\SearchModel**](../Model/\Swagger\Client\Model\SearchModel.md)|  | [optional]

### Return type

[**\Swagger\Client\Model\ProtocolNumber[]**](../Model/ProtocolNumber.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)


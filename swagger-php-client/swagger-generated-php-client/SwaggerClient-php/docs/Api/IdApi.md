# Swagger\Client\IdApi

All URIs are relative to *https://protocoltest.minedu.gov.gr:443/openpapyros/api*

Method | HTTP request | Description
------------- | ------------- | -------------
[**postProtocol**](IdApi.md#postProtocol) | **POST** /protocol/submit | Στο συγκεκριμένο URI μπορεί να πραγματοποιηθεί κλήση με μοναδικό αντκείμενο όπως περιγράφεται από το μοντέλο. Γνα να δεχτεί ο Server και να καταλάβει το έγγραφο (\&quot;document\&quot;: \&quot;string\&quot;) πρέπει αυτό να βρίσκεται σε Base64 μορφή


# **postProtocol**
> \Swagger\Client\Model\ProtocolNumber postProtocol($body)

Στο συγκεκριμένο URI μπορεί να πραγματοποιηθεί κλήση με μοναδικό αντκείμενο όπως περιγράφεται από το μοντέλο. Γνα να δεχτεί ο Server και να καταλάβει το έγγραφο (\"document\": \"string\") πρέπει αυτό να βρίσκεται σε Base64 μορφή



### Example
```php
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
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\Protocolin**](../Model/\Swagger\Client\Model\Protocolin.md)| Document Metadata |

### Return type

[**\Swagger\Client\Model\ProtocolNumber**](../Model/ProtocolNumber.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)


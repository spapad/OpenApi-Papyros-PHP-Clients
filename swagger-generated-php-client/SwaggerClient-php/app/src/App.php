<?php 
//
namespace Gr\Gov\Minedu\Osteam;

use Swagger\Client\ApiClient;
use Swagger\Client\Api\DefaultApi;
use Swagger\Client\Api\IdApi;
use Swagger\Client\Model\Credentials;
use Swagger\Client\ApiException;
use Swagger\Client\Model\SearchModel;
use Swagger\Client\Model\Protocolin;
use Swagger\Client\Model\DocumentDto;
use Swagger\Client\Model\Document;
use Swagger\Client\Model\DocumentDataDto;
use Swagger\Client\Model\ProtocolNumber;

/**
 * Description of app
 *
 * @author spapad
 */
class App
{

    private $_settings = [];
    private $_defaultApi = null;
    private $_idApi = null;
    private $_debug = false;

    /**
     * 
     * @param array $settings is an array of configuration parameters 
     */
    function __construct($settings = [])
    {
        $this->_settings = array_merge($this->_settings, $settings);
    }

    protected function getDefaultApi()
    {
        return $this->_defaultApi ? $this->_defaultApi : ($this->_defaultApi = new DefaultApi());
    }

    protected function getIdApi()
    {
        return $this->_idApi ? $this->_idApi : ($this->_idApi = new IdApi());
    }

    /**
     * 
     * @return string The api key 
     * @throws \Swagger\Client\ApiException 
     */
    public function getApiKey()
    {
        $api_instance = $this->getDefaultApi();
        $apiClient = $api_instance->getApiClient();
        $apiClient->getConfig()->setDebug($this->_debug);

        $body = new Credentials($this->_settings);

        $result = $api_instance->pauth($body);
        return $result->getApiKey();
    }

    public function searchDocuments($apikey = null)
    {
        $submission_data = [
//            'doc_type' => 20,
//            'start_date' => "2016-12-21T06:04:35.911Z",
//            'end_date' => "2015-12-01T06:04:35.911Z"
        ];

        $api_instance = $this->getDefaultApi();
        $apiClient = $api_instance->getApiClient();
        $apiClient->getConfig()->setDebug($this->_debug);
        $apiClient->getConfig()->addDefaultHeader('api_key', $apikey === null ? $this->getApiKey() : $apikey);

        $body = new SearchModel(array_merge($this->_settings, $submission_data));

        $result = $api_instance->searchDocuments($body);
        return $result;
    }

    public function getDocData($hashid, $apikey = null)
    {
        $api_instance = $this->getDefaultApi();
        $apiClient = $api_instance->getApiClient();
        $apiClient->getConfig()->setDebug($this->_debug);
        $apiClient->getConfig()->addDefaultHeader('api_key', $apikey === null ? $this->getApiKey() : $apikey);

        $result = $api_instance->getDocData($hashid);
        return $result;
    }

    public function submit($submission_data, $apikey = null)
    {
        $api_instance = $this->getIdApi();
        $apiClient = $api_instance->getApiClient();
        $apiClient->getConfig()->setDebug($this->_debug);
        $apiClient->getConfig()->addDefaultHeader('api_key', $apikey === null ? $this->getApiKey() : $apikey);

        $body = new Protocolin(array_merge($this->_settings, $submission_data));

        $result = $api_instance->postProtocol($body);
        return $result;
    }

    public function getPdf($hashid, $apikey = null)
    {
        $api_instance = $this->getDefaultApi();
        $apiClient = $api_instance->getApiClient();
        $apiClient->getConfig()->setDebug($this->_debug);
        $apiClient->getConfig()->addDefaultHeader('api_key', $apikey === null ? $this->getApiKey() : $apikey);

        $result = $api_instance->getPdf($hashid);
        return $result;
    }

    public function savePdf($hashid, $apikey = null)
    {
        $result = $this->getPdf($hashid, $apikey = null);
        $save = file_put_contents($result->getFileName(), base64_decode($result->getDocument()->getBase64()));
        return [
            'file_name' => $result->getFileName(),
            'description' => $result->getDescription(),
            'save' => ($save ? 'Αποθηκεύτηκε' : 'ΔΕΝ αποθηκεύθηκε')
        ];
    }

    /**
     * Try to return the object fields in a hash array
     * 
     * @param object $resultobj The object 
     * @return type
     */
    public function apiResultObjAsArray($resultobj)
    {
        $class = get_class($resultobj);

        $result = [];
        if (method_exists($resultobj, 'getters')) {
            $getters = $resultobj->getters();
            foreach ($getters as $property => $callfunc) {
                $result[$property] = $resultobj->$callfunc();
            }
        }
        return $result;
    }

    public function setDebug($debug = true)
    {
        $this->_debug = ($debug === true);
        return;
    }
}

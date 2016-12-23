<?php
//
namespace Gr\Gov\Minedu\Osteam;

use Gr\Gov\Minedu\Osteam\Client;

/**
 * Description of app
 *
 * @author spapad
 */
class App
{

    private $client = null;
    private $_settings = [];
    private $_debug = false;

    /**
     * 
     * @param array $settings is an array of configuration parameters 
     */
    function __construct($settings = [])
    {
        $this->_settings = array_merge($this->_settings, $settings);
        $this->client = new Client();
    }

    protected function setting($name)
    {
        return (isset($this->_settings["$name"]) ?
                $this->_settings["$name"] :
                null);
    }

    /**
     * 
     * @return string The api key 
     * @throws \Swagger\Client\ApiException 
     */
    public function getApiKey()
    {
        // debug?

        $payload = json_encode([
            'username' => $this->setting('username'),
            'password' => $this->setting('password')
        ]);

        $response = json_decode($this->client->pauth($payload));
        return $response->apiKey;
    }

    public function searchDocuments($apikey = null)
    {
        
    }

    public function getDocData($hashid, $apikey = null)
    {
        
    }

    public function submit($submission_data, $apikey = null)
    {
        
    }

    public function getPdf($hashid, $apikey = null)
    {
        
    }

    public function savePdf($hashid, $apikey = null)
    {
        
    }

    /**
     * Try to return the object fields in a hash array
     * 
     * @param object $resultobj The object 
     * @return type
     */
    public function apiResultObjAsArray($resultobj)
    {
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

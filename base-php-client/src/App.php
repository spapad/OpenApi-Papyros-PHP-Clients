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

    // Εισερχόμενο 
    const DOCUMENT_INCOMING = 1;
    // Εξερχόμενο 
    const DOCUMENT_OUTGOING = 2;

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
     * Λήψη κλειδιού πιστοποίησης.
     * 
     * @return string The api key 
     * @throws \Exception 
     */
    public function getApiKey()
    {
        $payload = json_encode([
            'username' => $this->setting('username'),
            'password' => $this->setting('password')
        ]);

        if ($this->_debug) {
            echo "getApiKey :: payload: {$payload}", PHP_EOL;
        }

        $response = json_decode($this->client->pauth($payload));
        return $response->apiKey;
    }

    /**
     * Αναζήτηση εγγράφων. 
     * 
     * @param int $sender_id Κωδικός αποστολέα, π.χ. 10000001
     *      Η προκαθορισμένη τιμή του senderId προέρχεται από τα settings
     * @param date $date_from Ημερομηνία αναζήτησης - Από
     * @param date $date_to Ημερομηνία αναζήτησης - Έως
     * @param int $doc_type Δείτε App::DOCUMENT_INCOMING, App::DOCUMENT_OUTGOING
     * @param type $apikey Κλειδί αυθεντικόποίησης
     * @return string[] Πίνακας με hashids
     * @throws \Exception 
     */
    public function searchDocuments($sender_id = null, $date_from = null, $date_to = null, $doc_type = null, $apikey = null)
    {
        $payload = json_encode([
            'senderId' => $sender_id === null ? $this->setting('sender_id') : null,
            'docType' => $doc_type,
            'startDate' => $date_from,
            'endDate' => $date_to
            ]
        );

        if ($this->_debug) {
            echo "searchDocuments :: payload: {$payload}", PHP_EOL;
        }

        $response = json_decode($this->client->searchDocuments($payload, $apikey === null ? $this->getApiKey() : $apikey));
        return $response;
    }

    /**
     * Ανάκτηση πληροφοριών εγγράφου.
     * 
     * @param type $hashid Το μοναδικό hashid του εγγράφου 
     * @param type $apikey Κλειδί αυθεντικόποίησης
     * @return string[] 
     * @throws \Exception 
     */
    public function getDocData($hashid, $apikey = null)
    {
        if ($this->_debug) {
            echo "getDocData:: hash id: {$hashid}", PHP_EOL;
        }

        $response = json_decode($this->client->getDocData($hashid, $apikey === null ? $this->getApiKey() : $apikey), true);
        return $response;
    }

    public function submit($submission_data, $apikey = null)
    {
        
    }

    public function getPdf($hashid, $apikey = null)
    {
        if ($this->_debug) {
            echo "getPdf:: hash id: {$hashid}", PHP_EOL;
        }

        $response = json_decode($this->client->getPdf($hashid, $apikey === null ? $this->getApiKey() : $apikey), true);
        return $response;
    }

    public function savePdf($hashid, $apikey = null)
    {
        if ($this->_debug) {
            echo "savePdf:: hash id: {$hashid}", PHP_EOL;
        }

        $result = $this->getPdf($hashid, $apikey = null);
        $save = file_put_contents($result["fileName"], base64_decode($result["document"]["base64"]));
        return [
            'file_name' => $result["fileName"],
            'description' => $result["description"],
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
        $this->client->setDebug($debug);
        return;
    }
}

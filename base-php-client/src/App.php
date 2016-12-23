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
    private $_files = [];

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

    public function postProtocol($submission_data, $apikey = null)
    {
        $postdata = array_merge([
            'senderId' => $this->setting('sender_id'),
            ], $submission_data
        );
        // take care of files...
        if (isset($postdata['mainDoc'])) {
            if (is_string($postdata['mainDoc']['document'])) {
                $postdata['mainDoc']['document'] = $this->_files[$postdata['mainDoc']['document']];
            }
        }
        if (isset($postdata['attachedDoc'])) {
            $postdata['attachedDoc'] = array_map(function ($doc) {
                if (is_string($doc['document'])) {
                    $doc['document'] = $this->_files[$doc['document']];
                }
                return $doc;
            }, $postdata['attachedDoc']);
        }

        $payload = json_encode($postdata);

        if ($this->_debug) {
            echo "postProtocol :: payload: {$payload}", PHP_EOL;
        }

        $response = json_decode($this->client->postProtocol($payload, $apikey === null ? $this->getApiKey() : $apikey), true);
        return $response;
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
     * Read a file to use later
     * 
     * @param string $filename The file to read
     * @return boolean
     */
    public function loadFile($filename)
    {
        if (is_readable($filename)) {
            $file = base64_encode(file_get_contents($filename));
            if ($file !== false) {
                $this->_files["$filename"] = $file;
                return true;
            }
        }
        return false;
    }

    public function setDebug($debug = true)
    {
        $this->_debug = ($debug === true);
        $this->client->setDebug($debug);
        return;
    }
}

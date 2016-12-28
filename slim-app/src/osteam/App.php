<?php
//
namespace Gr\Gov\Minedu\Osteam;

use Interop\Container\ContainerInterface;
use Slim\Http\Body;
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
    const DOCUMENT_INCOMING_STR = 'incoming';
    // Εξερχόμενο 
    const DOCUMENT_OUTGOING = 2;
    const DOCUMENT_OUTGOING_STR = 'outgoing';

    protected $ci = null;
    protected $client = null;
    private $username = '';
    private $password = '';
    private $sender_id = -1;
    private $_files = [];

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
        $settings = $this->ci->get('settings');
        $this->username = (isset($settings['username']) ? $settings['username'] : '');
        $this->password = (isset($settings['password']) ? $settings['password'] : '');
        $this->sender_id = (isset($settings['sender_id']) ? $settings['sender_id'] : '');
        $this->client = new Client();
    }

    /**
     * Send a JSON formatted string as JSON response to the client.
     *
     * @param  Response $res
     * @param  mixed $data The data
     * @param  int $status The HTTP status code.
     * @return response
     */
    public function withJsonReady($res, $data, $status = null)
    {
        $response = $res->withBody(new Body(fopen('php://temp', 'r+')));
        $response->getBody()->write($data);

        $jsonResponse = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        if (isset($status)) {
            return $jsonResponse->withStatus($status);
        }
        return $jsonResponse;
    }

    protected function setting($name)
    {
        throw new \Exception("Not implemented");
    }

    public function ping($req, $res, $args)
    {
        return $res->withJson([
                'username' => $this->username,
                'sender_id' => $this->sender_id,
        ]);
    }

    /**
     * Λήψη κλειδιού πιστοποίησης.
     * 
     * @return string The api key 
     * @throws \Exception 
     */
    protected function getApiKey()
    {
        $payload = json_encode([
            'username' => $this->username,
            'password' => $this->password
        ]);

        $response = json_decode($this->client->pauth($payload));
        return $response->apiKey;
    }

    /**
     * Λήψη κλειδιού πιστοποίησης.
     * 
     * @throws \Exception 
     */
    public function apiKey($req, $res, $args)
    {
        $payload = json_encode([
            'username' => $this->username,
            'password' => $this->password
        ]);

        return $this->withJsonReady($res, $this->client->pauth($payload));
    }

    /**
     * Ανάκτηση πληροφοριών εγγράφου.
     * 
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'hashid' Το μοναδικό hashid του εγγράφου 
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     */
    public function docData($req, $res, $args)
    {
        $hashid = (isset($args['hashid']) ? $args['hashid'] : '');
        $apikey = (isset($args['apikey']) ? $args['apikey'] : $this->getApiKey());

        return $this->withJsonReady($res, $this->client->getDocData($hashid, $apikey));
    }

    /**
     * Αναζήτηση εγγράφων. 
     * Εκτός από τις path parameters που περιγράφονται παρακάτω ($args) 
     * η μέθοδος αναζητά και τις παρακάτω (προεραιτικές) παραμέτρους στο
     * query string:
     *      'sender_id' Κωδικός αποστολέα, π.χ. 10000001
     *          Η προκαθορισμένη τιμή του senderId προέρχεται από τα settings 
     *      'date_from' (προεραιτικό) Ημερομηνία αναζήτησης - Από σε μορφή DATE_W3C
     *          κατά προτίμηση (μπορεί να είναι και YYYY-MM-DD ή άλλο)
     *          Η προκαθορισμένη τιμή είναι 5 μέρες πριν 
     *      'date_to' (προεραιτικό) Ημερομηνία αναζήτησης - Έως σε μορφή DATE_W3C
     *          κατά προτίμηση (μπορεί να είναι και YYYY-MM-DD ή άλλο)
     *          Η προκαθορισμένη τιμή είναι η χρονική στιγμή της κλήσης
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'doc_type' (προεραιτικό) Δείτε App::DOCUMENT_INCOMING, App::DOCUMENT_OUTGOING
     *          App::DOCUMENT_INCOMING_STR, App::DOCUMENT_OUTGOING_STR
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     */
    public function searchDocuments($req, $res, $args)
    {
        $doc_type = null;
        if (isset($args['doc_type'])) {
            if ($args['doc_type'] == self::DOCUMENT_INCOMING || $args['doc_type'] == self::DOCUMENT_INCOMING_STR) {
                $doc_type = self::DOCUMENT_INCOMING;
            } elseif ($args['doc_type'] == self::DOCUMENT_OUTGOING || $args['doc_type'] == self::DOCUMENT_OUTGOING_STR) {
                $doc_type = self::DOCUMENT_OUTGOING;
            }
        }
        $apikey = (isset($args['apikey']) ? $args['apikey'] : $this->getApiKey());

        $payload = json_encode([
            'senderId' => $req->getQueryParam('sender_id', $this->sender_id),
            'docType' => "$doc_type",
            'startDate' => $req->getQueryParam('date_from', date(DATE_W3C, mktime(0, 0, 0, date("m"), date("d") - 5, date("Y")))),
            'endDate' => $req->getQueryParam('date_to', date(DATE_W3C)),
            ]
        );

        return $res->withJson([
                'hashIds' => json_decode($this->client->searchDocuments($payload, $apikey))
        ]);
    }

    /**
     * Λήψη πληροφοριών αρχείου 
     * 
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'hashid' Το μοναδικό hashid του εγγράφου 
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     */
    public function pdfData($req, $res, $args)
    {
        $hashid = (isset($args['hashid']) ? $args['hashid'] : '');
        $apikey = (isset($args['apikey']) ? $args['apikey'] : $this->getApiKey());

        return $this->withJsonReady($res, $this->client->getPdf($hashid, $apikey));
    }

    /**
     * Λήψη - μεταφόρτωση αρχείου 
     * 
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'hashid' Το μοναδικό hashid του εγγράφου 
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     */
    public function pdfDownload($req, $res, $args)
    {
        $hashid = (isset($args['hashid']) ? $args['hashid'] : '');
        $apikey = (isset($args['apikey']) ? $args['apikey'] : $this->getApiKey());

        $result = json_decode($this->client->getPdf($hashid, $apikey), true);

        $res = $res->withBody(new Body(fopen('php://temp', 'r+')));
        $res->getBody()->write(base64_decode($result["document"]["base64"]));
        return $res
                ->withHeader('Content-Description', 'Get file ' . filter_var($result["description"], FILTER_SANITIZE_STRING))
                ->withHeader('Content-Type', 'application/pdf')
                ->withHeader('Content-Disposition', 'attachment;filename="' . basename($result["fileName"]) . '"')
                ->withHeader('Content-Transfer-Encoding', 'binary')
                ->withHeader('Expires', '0')
                ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->withHeader('Pragma', 'public');
    }

    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////

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

        $response = json_decode($this->client->postProtocol($payload, $apikey === null ? $this->getApiKey() : $apikey), true);
        return $response;
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
        $this->client->setDebug($debug === true);
        return;
    }
}

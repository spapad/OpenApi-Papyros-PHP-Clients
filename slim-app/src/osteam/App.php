<?php

namespace Gr\Gov\Minedu\Osteam\Slim;

use Interop\Container\ContainerInterface;
use Slim\Http\Body;
use Gr\Gov\Minedu\Osteam\Slim\Client;

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
    protected $logger = null;
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
        $this->client = new Client([
            'NO_SAFE_CURL' => (isset($settings['NO_SAFE_CURL']) ? $settings['NO_SAFE_CURL'] : false),
            'base_uri' => (isset($settings['base_uri']) ? $settings['base_uri'] : 'https://protocoltest.minedu.gov.gr:443/openpapyros/api')
        ]);
        if (($logger = $this->ci->get('logger')) != null) {
            $this->logger = $logger;
        }
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

    protected function log($msg)
    {
        if ($this->logger) {
            $this->logger->info($msg);
        }
    }

    /**
     * Provide information about default values used in app.
     * 
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param array $args
     * @return Response
     */
    public function defaults($req, $res, $args)
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
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param array $args
     * @return Response
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
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'hashid' Το μοναδικό hashid του εγγράφου 
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     * @return Response
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
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'doc_type' (προεραιτικό) Δείτε App::DOCUMENT_INCOMING, App::DOCUMENT_OUTGOING
     *          App::DOCUMENT_INCOMING_STR, App::DOCUMENT_OUTGOING_STR
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     * @return Response
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
        $apikey = $req->getQueryParam('apikey', $this->getApiKey());

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
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'hashid' Το μοναδικό hashid του εγγράφου 
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     * @return Response
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
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param string[] $args Πίνακας με παραμέτρους από το call:
     *      'hashid' Το μοναδικό hashid του εγγράφου 
     *      'apikey' (προεραιτικό) Κλειδί αυθεντικοποίησης
     * @throws \Exception 
     * @return Response
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

    /**
     * Αποστολή αρχείου/ων και λήψη πρωτοκόλλου.
     * 
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param array $args
     * @return Response
     */
    public function postProtocol($req, $res, $args)
    {
        $apikey = (isset($args['apikey']) ? $args['apikey'] : $this->getApiKey());

        $params = $req->getParams();
        $files = $req->getUploadedFiles();
        $mainDoc = null;
        $attachedDocs = [];
        if (count($files) > 0) {
            foreach ($files as $id => $file) {
                if ($file->getError() === UPLOAD_ERR_OK) {
                    $file_contents = base64_encode($file->getStream()->getContents());
                    if ($file_contents !== false) {
                        $payload_item = [
                            'document' => $file_contents,
                            'fileName' => $file->getClientFilename(),
                            'description' => null
                        ];
                        if ($id === 'mainDoc') {
                            $mainDoc = $payload_item;
                        } else {
                            $attachedDocs[] = $payload_item;
                        }
                    }
                }
            }
        }

        $payload_items = [
            'senderId' => $req->getParam('sender_id', $this->sender_id),
            'theme' => $req->getParam('theme'),
            'description' => $req->getParam('description'),
            'docCategory' => $req->getParam('docCategory', 20),
            'mainDoc' => $mainDoc,
            'attachedDoc' => (count($attachedDocs) > 0 ? $attachedDocs : null)
            // αντίστοιχα εδώ μπορούν να προστεθούν και όλες οι υπόλοιπες παράμετροι, π.χ. ADA
        ];

        $payload = json_encode($payload_items);

        return $this->withJsonReady($res, $this->client->postProtocol($payload, $apikey));
    }

    public function setDebug($debug = true)
    {
        $this->client->setDebug($debug === true);
        return;
    }

}

<?php
/*
 * 
 */
namespace Gr\Gov\Minedu\Osteam;

use Exception;

/**
 * Description of Client
 *
 * @author spapad
 */
class Client
{

    private $_debug = false;
    private $_settings = [
        'base_uri' => 'https://protocoltest.minedu.gov.gr:443/openpapyros/api'
    ];

    public function __construct($settings = [])
    {
        $this->_settings = array_merge($this->_settings, $settings);
    }

    public function pauth($payload)
    {
        $result = $this->put("{$this->_settings['base_uri']}/pauthenticate/pauth", $payload, [
            "Content-Type: application/json",
            "Accept: application/json",
            ]
        );
        return $result;
    }

    public function searchDocuments($payload, $apikey)
    {
        $result = $this->post("{$this->_settings['base_uri']}/search/documents", $payload, [
            "api_key: {$apikey}",
            "Content-Type: application/json",
            "Accept: application/json",
            ]
        );
        return $result;
    }

    public function getDocData($hashid, $apikey)
    {
        $result = $this->get("{$this->_settings['base_uri']}/document/data/{$hashid}", [], [
            "api_key: {$apikey}",
            "Content-Type: text/plain",
            "Accept: application/json",
            ]
        );
        return $result;
    }

    public function getPdf($hashid, $apikey)
    {
        $result = $this->get("{$this->_settings['base_uri']}/document/pdf/{$hashid}", [], [
            "api_key: {$apikey}",
            "Content-Type: text/plain",
            "Accept: application/json",
            ]
        );
        return $result;
    }

    public function postProtocol($payload, $apikey)
    {
        $result = $this->post("{$this->_settings['base_uri']}/protocol/submit", $payload, [
            "api_key: {$apikey}",
            "Content-Type: application/json",
            "Accept: application/json",
            ]
        );
        return $result;
    }

    protected function setCommonCurlOptions($ch, $uri, $headers)
    {
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, "OSTEAM barebone php client");

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        if ($this->_debug === true) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
        }
    }

    public function put($uri, $payload, $headers = [])
    {
        $ch = curl_init();

        $this->setCommonCurlOptions($ch, $uri, $headers);

        // curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("Λάθος κατά την κλήση του {$uri}. Curl error: " . curl_error($ch) . " Curl info: " . var_export(curl_getinfo($ch), true));
        }
//        if (intval(($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) / 100) != 2) {
            // πραγματοποιήθηκε κλήση αλλά δεν ήταν "επιτυχής"
//            throw new Exception("Αποτυχημένη κλήση. HTTP STATUS {$http_code}. Η απάντηση ήταν: {$result}", $http_code);
//        }
        curl_close($ch);
        return $result;
    }

    public function post($uri, $payload, $headers = [])
    {
        $ch = curl_init();

        $this->setCommonCurlOptions($ch, $uri, $headers);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("Λάθος κατά την κλήση του {$uri}. Curl error: " . curl_error($ch) . " Curl info: ", var_export(curl_getinfo($ch), true));
        }
//        if (intval(($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) / 100) != 2) {
            // πραγματοποιήθηκε κλήση αλλά δεν ήταν "επιτυχής"
//            throw new Exception("Αποτυχημένη κλήση. HTTP STATUS {$http_code}. Η απάντηση ήταν: {$result}", $http_code);
//        }
        curl_close($ch);
        return $result;
    }

    public function get($uri, $params = [], $headers = [])
    {
        $ch = curl_init();

        if (is_array($params) && count($params) > 0) {
            $qs = '?' . http_build_query($params);
        } else {
            $qs = '';
        }
        $this->setCommonCurlOptions($ch, "{$uri}{$qs}", $headers);

//        curl_setopt($ch, CURLOPT_HTTPGET, true); // default
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("Λάθος κατά την κλήση του {$uri}. Curl error: " . curl_error($ch) . " Curl info: ", var_export(curl_getinfo($ch), true));
        }
//        if (intval(($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) / 100) != 2) {
            // πραγματοποιήθηκε κλήση αλλά δεν ήταν "επιτυχής"
//            throw new Exception("Αποτυχημένη κλήση. HTTP STATUS {$http_code}. Η απάντηση ήταν: {$result}", $http_code);
//        }
        curl_close($ch);
        return $result;
    }

    public function setDebug($debug = true)
    {
        $this->_debug = ($debug === true);
        return;
    }
}

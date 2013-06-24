<?php
require 'vendor/autoload.php';
use Httpful\Http;
use Httpful\Request;
use Httpful\Mime;

/**
 * Wrapper class to open and handle communication from/to SMS Global REST API.
 * This file only serves as a illustration purpose only and should be revised if included into your project.
 *
 * @author Huy Dinh <huy.dinh@smsglobal.com>
 */

class SMSGlobalAPIWrapper
{
    protected $key;
    protected $secret;
    protected $protocol;
    protected $host;
    protected $port;
    protected $apiVersion;
    protected $extraData;
    protected $debug = false;

    /**
     * @param $key
     * @param $secret
     * @param string $protocol
     * @param string $host
     * @param string $port
     * @param string $apiVersion
     * @param string $extraData
     * @param bool $debug
     */
    public function __construct($key, $secret, $protocol = "http", $host = "api.smsglobal.com", $port = "80", $apiVersion = "v1", $extraData = "", $debug = false)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->protocol = strtolower($protocol);
        $this->host = $host;
        $this->port = $port;
        $this->apiVersion = $apiVersion;
        $this->extraData = $extraData;
        $this->debug = $debug;
    }

    public function get($action, $id = null) {
        return $this->connect("GET", $action, $id);
    }

    public function post($action, $id = null) {
        return $this->connect("POST", $action, $id);
    }

    public function delete($action, $id = null) {
        return $this->connect("DELETE", $action, $id);
    }


    /**
     * @param $method
     * @param $action
     * @param null $id
     * @return mixed
     * @throws Exception when there's something wrong with the request/response
     */
    private function connect($method, $action, $id = null) {
        $action = !$id ? "/$action" : "/$action/id/$id";

        $uri = "{$this->protocol}://{$this->host}:{$this->port}/{$this->apiVersion}{$action}";

        $request = Request::init()
            ->expects(Mime::JSON)
            ->addHeaders($this->getAuthorisationHTTPHeader($method, $action))
            ->uri($uri);

        if ($this->protocol == "https") {
            // Dangerous, should not use for PRODUCTION
            $request->withoutStrictSSL();
        }

        switch ($method) {
            case "GET":
                $request->method(Http::GET);
                break;
            case "POST":
                $request->method(Http::POST);
                break;
            case "DELETE":
                $request->method(Http::DELETE);
                break;
        }

        if ($this->debug) {
            $request->_debug = true;
        }

        try {
            // do it!
            $response = $request->send();

            return $response;
        } catch (Exception $e) {
            if($this->debug) {
                throw $e;
            } else {
                throw new \Exception('Unable to connect to the server.');
            }
        }
    }

    /**
     * @param $method
     * @param $action
     * @return array of HTTP headers in key/value pair
     */
    private function getAuthorisationHTTPHeader($method, $action)
    {
        $algorithm = "sha256";
        $timestamp = time();

        # Random String
        $nonce = md5(microtime() . mt_rand());

        # Hence
        $rawStr = $timestamp . "\n"
                . $nonce . "\n"
                . $method . "\n"
                . $action . "\n"
                . $this->host . "\n"
                . $this->port . "\n"
                . $this->extraData . "\n";

        var_dump($rawStr);
        # Encryptions
        $hash = hash_hmac($algorithm, $rawStr, $this->secret, true);
        $hash = base64_encode($hash);

        return array("Authorization" => sprintf('MAC id="%s", ts="%s", nonce="%s", mac="%s"', $this->key, $timestamp, $nonce, $hash));
    }
}

?>
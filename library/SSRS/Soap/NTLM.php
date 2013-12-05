<?php

namespace SSRS\Soap;

class NTLM extends \SoapClient {

    protected $_uri;
    protected $_username;
    protected $_passwd;
    protected $_cachePath;
    protected $_cacheExpiry;
    protected $_lastRequest;
    protected $_lastResponse;

    function __construct($wsdl, $options = array()) {
        if (!array_key_exists('cache_wsdl_path', $options)) {
            $options['cache_wsdl_path'] = '/tmp/' . md5($wsdl) . '.wsdl';
        }

        if (array_key_exists('username', $options)) {
            $this->setUsername($options['username']);
        }

        if (array_key_exists('password', $options)) {
            $this->setPassword($options['password']);
        }

        $this->setUri($wsdl);
        $this->setCachePath($options['cache_wsdl_path']);
    }

    public function init() {
        $this->fetchWSDL();

        $options['cache_wsdl'] = WSDL_CACHE_MEMORY;
        $options['login'] = $this->_username;
        $options['password'] = $this->_passwd;

        parent::__construct($this->_cachePath, $options);
        return $this;
    }

    public function setUri($uri) {
        $this->_uri = $uri;
        return $this;
    }

    public function getUri() {
        return $this->_uri;
    }

    public function setCacheExpiry($cacheExpiry = 86400) {
        $this->_cacheExpiry = $cacheExpiry;
        return $this;
    }

    public function getCacheExpiry() {
        return $this->_cacheExpiry;
    }

    public function isCacheValid() {
        $checkTime = time() - $this->getCacheExpiry();
        return (file_exists($this->getCachePath()) && filemtime($this->getCachePath()) > $checkTime);
    }

    public function setUsername($username) {
        $this->_username = (string) $username;
        return $this;
    }

    public function setPassword($password) {
        $this->_passwd = (string) $password;
        return $this;
    }

    public function setCachePath($path) {
        $folder = dirname($path);

        if (!is_dir($folder)) {
            throw new Exception('WSDL cache path is not valid');
        }

        if (!is_writeable($folder)) {
            throw new Exception('WSDL cache path not writeable');
        }

        $this->_cachePath = $path;
        return $this;
    }

    public function getCachePath() {
        return $this->_cachePath;
    }

    public function cacheWSDL($fileContents) {
        $result = file_put_contents($this->_cachePath, $fileContents);
        if ($result) {
            $this->setCacheWSDLPermission(0666);
        }
    }

    public function setCacheWSDLPermission($oct = 0666) {
        @chmod($this->_cachePath, 0666);
    }

    public function getCacheWSDL() {
        return file_get_contents($this->getCachePath());
    }

    public function fetchWSDL() {
        if ($this->isCacheValid() === false) {
            $wsdlContent = $this->callCurl($this->_uri);
            $this->cacheWSDL($wsdlContent);
        }
    }

    public function __doRequest($data, $url, $action) {
        $this->_lastRequest = (string) $data;
        $this->_lastResponse = $this->callCurl($url, $data, $action);
        return $this->_lastResponse;
    }

    public function callCurl($url, $data = null, $action = null) {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_FAILONERROR, false);
        curl_setopt($handle, CURLOPT_USERAGENT, 'PHP SOAP-NTLM Client');
        curl_setopt($handle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_USERPWD, $this->_username . ':' . $this->_passwd);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);

        $headers = array(
            'Method: ' . ($data === null) ? 'GET' : 'POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
        );

        if ($data !== null) {
            $headers[] = 'Content-Type: text/xml; charset=utf-8';
            $headers[] = 'Content-Length: ' . strlen($data);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        }

        if ($action !== null) {
            $headers[] = 'SOAPAction: "' . $action . '"';
        }

        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($handle);
        if ($response === false) {
            throw new SSRS_Soap_Exception('CURL error: ' . curl_error($handle), curl_errno($handle));
        }

        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($httpCode >= 300 && $httpCode <= 600) {
            throw ServerException::fromResponse($response);
        } else if ($httpCode !== 200) {
            throw new Exception('HTTP error: ' . $httpCode . ' ' . $response, $httpCode, $response);
        }
        curl_close($handle);

        $this->_lastResponse = (string) $response;
        return $response;
    }

    public function getLastRequest() {
        return $this->_lastRequest;
    }

    public function getLastResponse() {
        return $this->_lastResponse;
    }

}
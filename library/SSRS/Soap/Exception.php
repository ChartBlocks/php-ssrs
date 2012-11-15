<?php

class SSRS_Soap_Exception extends Exception{
    
    public $httpCode;
    public $response;
    
    public function __construct($message, $code, $response = null) {
        $this->httpCode = $code;
        $this->response = $response;
        
        parent::__construct($message, $code);
    }
    
}
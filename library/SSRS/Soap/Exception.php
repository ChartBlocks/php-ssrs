<?php

namespace SSRS\Soap;

class Exception extends \Exception {

    public $httpCode;
    public $response;

    public function __construct($message, $code = null, $response = null) {
        $this->httpCode = $code;
        $this->response = $response;

        parent::__construct($message, $code);
    }

}

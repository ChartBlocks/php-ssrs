<?php

class SSRS_Soap_ServerException extends Exception {

    public $faultcode;
    public $faultstring;
    public $faultactor;

    static function fromResponse($string) {
        $xml = new SimpleXMLElement($string);
        $ns = $xml->getNamespaces(true);

        $soap = $xml->children($ns['soap']);
        $body = $soap->Body->children($ns['soap']);
        if (isset($body->Fault)) {
            $fault = $body->Fault->children();

            $exception = new SSRS_Soap_ServerException((string) $fault->faultstring);
            $exception->faultcode = (string) $fault->faultcode;
            $exception->faultstring = (string) $fault->faultstring;
            $exception->faultactor = (string) $fault->faultactor;
        } else {
            throw new SSRS_Soap_Exception('Invalid server response');
        }

        return $exception;
    }

}
<?php

namespace SSRS\Object;

class RenderStream extends ObjectAbstract {

    public $Result;
    public $MimeType;

    public function __construct(\stdClass $stream = null) {
        if ($stream) {
            $this->Result = $stream->Result;
            $this->MimeType = $stream->MimeType;
        }
    }

    public function send() {
        header('Content-Type: ' . $this->MimeType);
        echo $this->Result;
    }

    public function __toString() {
        return $this->Result;
    }

}

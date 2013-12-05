<?php

namespace SSRS\Object;

class RenderStream extends ObjectAbstract {

    public $Result;
    public $MimeType;

    public function __construct(stdClass $stream) {
        $this->Result = $stream->Result;
        $this->MimeType = $stream->MimeType;
    }

    public function __toString() {
        return $this->Result;
    }

}

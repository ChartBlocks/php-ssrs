<?php

/**
 * SSRS_Object_RenderStream
 *
 * @author arron
 */
class SSRS_Object_RenderStream extends SSRS_Object_Abstract {

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
<?php

namespace SSRS\Report;

use \SSRS\Object\RenderStream;

class CachedStreamResource {

    public $streamId;
    public $filePath;

    public function __construct($streamId, $filePath) {
        $this->streamId = $streamId;
        $this->filePath = $filePath;
    }

    public function read() {
        if (false === file_exists($this->filePath)) {
            throw new HttpUserException('Resource file not found', 404);
        }

        $data = file_get_contents($this->filePath);
        $parts = explode("\n", $data, 2);

        $stream = new RenderStream();
        $stream->MimeType = $parts[0];
        $stream->Result = $parts[1];

        return $stream;
    }

    public function store(RenderStream $renderStream) {
        $data = trim($renderStream->MimeType) . "\n";
        $data .= $renderStream->Result;

        file_put_contents($this->filePath, $data);
        return $this;
    }

    public function send() {
        $stream = $this->read();
        $stream->send();
        return $this;
    }

}

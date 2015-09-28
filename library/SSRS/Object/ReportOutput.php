<?php

namespace SSRS\Object;

use SSRS\Report;
use SSRS\Report\CachedStreamResource;
use SSRS\Object\ExecutionInfo;

class ReportOutput extends ObjectAbstract {

    public function __construct($data = null, ExecutionInfo $executionInfo = null) {
        parent::__construct($data);
        $this->executionInfo = $executionInfo;
    }

    public function preCacheStreams(Report $report, $localCachePath, $format = 'HTML4.0') {
        $this->verifyCachePath($localCachePath);

        $rootPath = rtrim($localCachePath, '/');

        $streamIds = $this->getStreamIds();
        foreach ($streamIds as $streamId) {
            $path = $rootPath . '/' . $streamId;
            $stream = $report->renderStream($format, $streamId);

            $cachedResource = new CachedStreamResource($streamId, $path);
            $cachedResource->store($stream);
        }

        return $this;
    }

    public function getStreamIds() {
        if(empty($this->StreamIds->string)){
            return array();
        }

        $ids = is_array($this->StreamIds->string) ? $this->StreamIds->string : array($this->StreamIds->string);
        return array_filter($ids);
    }

    public function download($filename) {
        header("Cache-control: max-age=3600, must-revalidate");
        header("Pragma: public");
        header("Expires: -1");
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Content-Type: " . $this->MimeType);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . strlen($this->Result));

        echo($this->Result);
        exit(0);
    }

    public function resultClean() {
        $output = (string) $this->Result;
        $clean = $this->convertReplacementRootUrls($output);

        return $clean;
    }

    protected function convertReplacementRootUrls($output) {
        $executionId = ($this->executionInfo) ? $this->executionInfo->getExecutionId() : null;

        return preg_replace_callback('#href="//php-ssrs//([^\?]+)([^"]+)"#', function($results) use($executionId) {
            return 'href="' . html_entity_decode(urldecode($results[2])) . '&executionId=' . $executionId . '"';
        }, $output);
    }

    public function __toString() {
        return $this->resultClean();
    }

    protected function verifyCachePath($path) {
        if (false === file_exists($path) || false === is_dir($path)) {
            throw new \RuntimeException('Stream cache path does not exist');
        }

        if (false === is_writable($path)) {
            throw new \RuntimeException('Stream cache path is not writeable');
        }

        return $this;
    }

}

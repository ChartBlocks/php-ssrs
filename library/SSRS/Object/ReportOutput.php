<?php

namespace SSRS\Object;

use SSRS\Report;
use SSRS\Report\CachedStreamResource;

class ReportOutput extends ObjectAbstract {

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
        return is_array($this->StreamIds->string) ? $this->StreamIds->string : array($this->StreamIds->string);
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

    public function __toString() {
        return (string) $this->Result;
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

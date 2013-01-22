<?php

/**
 * Description of ExecutionParameters
 *
 * @author andrew
 */
class SSRS_Object_ReportOutput extends SSRS_Object_Abstract {

    public function download($filename) {
        header("Cache-control: no-cache");
        header("Pragma: no-cache");
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

}

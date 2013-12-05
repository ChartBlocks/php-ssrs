<?php

namespace SSRS\Object;

class ReportOutput extends ObjectAbstract {

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

}

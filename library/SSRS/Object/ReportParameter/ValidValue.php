<?php

namespace SSRS\Object\ReportParameter;

class ValidValue {

    /**
     * capitals because of SSRS!
     */
    public $Value;
    public $Label;

    public function __construct($label, $value) {
        $this->Value = $value;
        $this->Label = $label;
    }

    public function __toString() {
        return $this->Value;
    }

}

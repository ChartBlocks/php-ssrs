<?php

/**
 * Description of ExecutionParameters
 *
 * @author andrew
 */
class SSRS_Object_ReportParameter extends SSRS_Object_Abstract {

    public function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public $name;
    public $value;

}

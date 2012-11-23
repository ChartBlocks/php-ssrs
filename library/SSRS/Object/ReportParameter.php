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

    public function getValidValues() {
        $data = false;
        
        if (key_exists('ValidValues', $this->data)) {
            $data = array();

            if (is_object($this->data['ValidValues']->ValidValue)) {
                $data[$this->data['ValidValues']->ValidValue->Label] = $this->data['ValidValues']->ValidValue->Value;
            } else {
                foreach ($this->data['ValidValues']->ValidValue AS $value) {
                    $data[$value->Label] = $value->Value;
                }
            }

            if (!empty($this->data['AllowBlank'])) {
                $data['AllowBlank'] = '';
            }
        }

        return $data;
    }

}

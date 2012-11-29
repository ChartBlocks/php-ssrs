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

    public function getDefaultValue() {
        $defaults = array();

        if (key_exists('DefaultValues', $this->data)) {
            $defaults = (array) $this->data['DefaultValues']->Value;
        }

        $validValues = array();
        foreach ($this->getValidValues() AS $validValue) {
            $validValues[] = $validValue->Value;
        }

        $validDefaults = array_intersect($defaults, $validValues);
        return $validDefaults;
    }

    public function getValidValues() {
        $data = array();

        if (key_exists('ValidValues', $this->data)) {
            $data = array();

            if (is_object($this->data['ValidValues']->ValidValue)) {
                $data[] = new SSRS_Object_ReportParameter_ValidValue($this->data['ValidValues']->ValidValue->Label,
                                $this->data['ValidValues']->ValidValue->Value);
            } else {
                foreach ($this->data['ValidValues']->ValidValue AS $value) {
                    if (is_object($value)) {
                        $data[] = new SSRS_Object_ReportParameter_ValidValue($value->Label, $value->Value);
                    } else {
                        $data[] = new SSRS_Object_ReportParameter_ValidValue((string) $value, (string) $value);
                    }
                }
            }

//            if (!empty($this->data['AllowBlank'])) {
//                $data[] = new SSRS_Object_ReportParameter_ValidValue('', '');
//            }
        }
        return $data;
    }

    public function hasDependencies() {
        return (isset($this->data['Dependencies']->Dependency)
                && !empty($this->data['Dependencies']->Dependency));
    }

    public function getDependencies() {
        return (array) $this->data['Dependencies']->Dependency;
    }

    public function hasOutstandingDependencies() {
        return ($this->getState() == 'HasOutstandingDependencies');
    }

    public function getState() {
        return key_exists('State', $this->data) ? $this->data['State'] : null;
    }

    public function isMultiValue() {
        return !empty($this->data['MultiValue']);
    }

}

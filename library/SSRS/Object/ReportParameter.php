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

    /**
     *
     * @return array
     */
    public function getDefaultValue() {
        $defaults = array();

        if (key_exists('DefaultValues', $this->data) && isset($this->data['DefaultValues']->Value)) {
            $defaults = (array) $this->data['DefaultValues']->Value;
        }

        if ($this->isSelect()) {
            $validValues = array();
            foreach ($this->getValidValues() AS $validValue) {
                $validValues[] = $validValue->Value;
            }

            $defaults = array_intersect($defaults, $validValues);
        }

        return $defaults;
    }

    public function setValidValues($validValues) {
        if ($validValues instanceof stdClass && isset($validValues->ValidValue) && is_object($validValues->ValidValue)) {
            $validValues = array($validValues->ValidValue);
        } elseif ($validValues instanceof stdClass && isset($validValues->ValidValue)) {
            $validValues = $validValues->ValidValue;
        }

        $data = array();
        foreach ($validValues AS $value) {
            if (is_object($value)) {
                $data[] = new SSRS_Object_ReportParameter_ValidValue((string) $value->Label, (string) $value->Value);
            } elseif (is_array($value)) {
                $data[] = new SSRS_Object_ReportParameter_ValidValue((string) $value['Label'], (string) $value['Value']);
            } else {
                $data[] = new SSRS_Object_ReportParameter_ValidValue((string) $value, (string) $value);
            }
        }

        $this->data['ValidValues'] = $data;
        return $this;
    }

    /**
     *
     * @return \SSRS_Object_ReportParameter_ValidValue[]
     */
    public function getValidValues() {
        return empty($this->data['ValidValues']) ? array() : $this->data['ValidValues'];
    }

    /**
     *
     * @return bool 
     */
    public function hasDependencies() {
        return (isset($this->data['Dependencies']->Dependency)
                && !empty($this->data['Dependencies']->Dependency));
    }

    /**
     *
     * @return bool 
     */
    public function getDependencies() {
        return (array) $this->data['Dependencies']->Dependency;
    }

    /**
     *
     * @return bool 
     */
    public function hasOutstandingDependencies() {
        return ($this->getState() == 'HasOutstandingDependencies');
    }

    /**
     *
     * @return bool 
     */
    public function getState() {
        return key_exists('State', $this->data) ? $this->data['State'] : null;
    }

    /**
     *
     * @return bool 
     */
    public function isMultiValue() {
        return !empty($this->data['MultiValue']);
    }

    /**
     *
     * @return bool 
     */
    public function isSelect() {
        return !empty($this->data['ValidValues']);
    }

}

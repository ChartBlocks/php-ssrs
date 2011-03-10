<?php

/**
 * Description of ExecutionParameters
 *
 * @author andrew
 */
class SSRS_Object_ExecutionParameters extends SSRS_Object_ArrayIterator{

    public $iteratorKey = 'Parameters';

    public function init() {
        $this->data['Parameters'] = array();
    }

    public function setParameters(SSRS_Object_ReportParameters $parameters) {
        foreach ($parameters AS $parameter) {
            if (($parameters instanceof SSRS_Object_ExecutionParameter) === false) {
                $parameter = new SSRS_Object_ExecutionParameter($parameter);
            }

            $this->data['Parameters'][] = $parameter;
        }
    }

    public function getParameterArrayForSoapCall(){
        $execParams = array();
        foreach ($this AS $parameter) {
            $execParams[] = array(
                'Name' => $parameter->Name,
                'Value' => $parameter->Value,
            );
        }

        return $execParams;
    }

}

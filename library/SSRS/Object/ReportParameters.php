<?php

/**
 * Description of ExecutionParameters
 *
 * @author andrew
 */
class SSRS_Object_ReportParameters extends SSRS_Object_ArrayIterator{

    public $iteratorKey = 'Parameters';

    public function init() {
        $this->data['Parameters'] = array();
    }

    public function setParameters($parameters) {
        foreach ($parameters AS $parameter) {
            if (($parameters instanceof SSRS_Object_ReportParameter) === false) {
                $parameter = new SSRS_Object_ReportParameter($parameter);
            }

            $this->data['Parameters'][] = $parameter;
        }
    }

}

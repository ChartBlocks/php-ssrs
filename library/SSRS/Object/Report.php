<?php

/**
 * Description of ExecutionParameters
 *
 * @author andrew
 */
class SSRS_Object_Report extends SSRS_Object_Abstract{

    public function setExecutionInfo(stdClass $info){
        $this->data['executionInfo'] = new SSRS_Object_ExecutionInfo($info);
    }

}

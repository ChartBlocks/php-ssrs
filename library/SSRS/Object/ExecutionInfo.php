<?php

/**
 * SSRS_Object_Abstract
 *
 * @author arron
 */
class SSRS_Object_ExecutionInfo extends SSRS_Object_Abstract {

    public function setExecutionInfo(stdClass $info) {
        $this->setData($info);
    }

    public function setParameters(stdClass $params){
        $this->data['Parameters'] = new SSRS_Object_ReportParameters();
        $this->data['Parameters']->setParameters($params->ReportParameter);
    }

}

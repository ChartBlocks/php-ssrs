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

    public function setParameters(stdClass $params) {
        $parameters = array();
        foreach ($params->ReportParameter AS $reportParam) {
            $parameter = new SSRS_Object_ReportParameter($reportParam->Name, null);
            $parameter->setData($reportParam);

            $parameters[] = $parameter;
        }

        $execParams = new SSRS_Object_ExecutionParameters();
        $execParams->setParameters($parameters);

        $this->data['Parameters'] = $execParams;
    }

}

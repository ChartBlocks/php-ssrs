<?php

/**
 * SSRS_Object_Abstract
 *
 * @author arron
 */
class SSRS_Object_ExecutionInfo extends SSRS_Object_Abstract {

    /**
     * Copy of self for backwards compatibility
     * 
     * @var SSRS_Object_ExecutionInfo
     */
    public $executionInfo;

    public function __construct(stdClass $info) {
        $this->setData($info->executionInfo);
        $this->executionInfo = $this;
    }

    public function setParameters(stdClass $params) {
        return $this->setReportParameters($params);
    }

    public function setReportParameters(stdClass $params) {
        $parameters = array();
        if (isset($params->ReportParameter)) {
            $reportParameters = is_array($params->ReportParameter) ? $params->ReportParameter : array($params->ReportParameter);
            foreach ($reportParameters AS $reportParam) {
                $parameter = new SSRS_Object_ReportParameter($reportParam->Name, isset($reportParam->Value) ? $reportParam->Value : null);
                $parameter->setData($reportParam);

                $parameters[] = $parameter;
            }
        }

        $this->data['ReportParameters'] = $parameters;
        return $this;
    }
    
    public function getReportPath(){
        return $this->data['ReportPath'];
    }

    /**
     * Returns all report parameters in an array
     * 
     * @return array parameters 
     * 
     */
    public function getReportParameters() {
        return $this->data['ReportParameters'];
    }

    public function getReportParameter($name) {
        $parameters = $this->getReportParameters();
        foreach ($parameters AS $parameter) {
            if ($parameter->name === $name) {
                return $parameter;
            }
        }

        return null;
    }

}

<?php

namespace SSRS\Object;

class ExecutionInfo extends ObjectAbstract {

    /**
     * Copy of self for backwards compatibility
     * 
     * @var SSRS\Object\ExecutionInfo
     */
    public $executionInfo;

    public function __construct(\stdClass $info = null) {
        if ($info) {
            $this->setData($info->executionInfo);
        }

        $this->executionInfo = $this;
    }

    public function getExecutionId() {
        return empty($this->data['ExecutionID']) ? null : $this->data['ExecutionID'];
    }

    public function getExpirationTimestamp() {
        return strtotime($this->data['ExpirationDateTime']);
    }

    public function setParameters(\stdClass $params) {
        return $this->setReportParameters($params);
    }

    public function setReportParameters($reportParameters) {
        $parameters = array();

        if ($reportParameters instanceof \stdClass) {
            $reportParameters = isset($reportParameters->ReportParameter) ? $reportParameters->ReportParameter : array();
            $reportParameters = is_array($reportParameters) ? $reportParameters : array($reportParameters);
        }

        foreach ($reportParameters AS $reportParam) {
            if (is_object($reportParam)) {
                $data = array(
                    'name' => $reportParam->Name,
                    'value' => isset($reportParam->Value) ? $reportParam->Value : null
                );
            } else {
                $data = $reportParam;
            }

            $parameter = new ReportParameter($data['name'], $data['value']);
            $parameter->setData($reportParam);

            $parameters[] = $parameter;
        }

        $this->data['ReportParameters'] = $parameters;
        return $this;
    }

    public function getReportPath() {
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

    public function __sleep() {
        $this->executionInfo = null;
        return array('data');
    }

    public function __wakeup() {
        //$this->executionInfo = $this;
    }

    public function getPageCount() {
        return isset($this->data['NumPages']) ? $this->data['NumPages'] : 1;
    }

}

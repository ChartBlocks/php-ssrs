<?php

namespace SSRS\Form\Adapter;

use SSRS\Object\ExecutionInfo;

abstract class AbstractAdapter implements AdapterInterface {

    protected $executionInfo;

    public function __construct(ExecutionInfo $executionInfo) {
        $this->setExecutionInfo($executionInfo);
    }

    public function setExecutionInfo(ExecutionInfo $executionInfo) {
        $this->executionInfo = $executionInfo;
        return $this;
    }

}

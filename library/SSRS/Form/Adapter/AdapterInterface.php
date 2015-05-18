<?php

namespace SSRS\Form\Adapter;

use SSRS\Object\ExecutionInfo;

interface AdapterInterface {

    public function __construct(ExecutionInfo $executionInfo);

    public function setExecutionInfo(ExecutionInfo $executionInfo);

    public function getHTML();

    public function validate($data);

    public function addCSRFElement($name, $value);
}

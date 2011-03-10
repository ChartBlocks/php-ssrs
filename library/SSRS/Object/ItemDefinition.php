<?php

/**
 * Description of ExecutionParameters
 *
 * @author andrew
 */
class SSRS_Object_ItemDefinition extends SSRS_Object_Abstract {

    public function getXMLString() {
        return $this->Definition;
    }

    public function getSimpleXML() {
        return new SimpleXMLElement($this->getXMLString());
    }

    public function __toString() {
        return $this->getXMLString();
    }

}

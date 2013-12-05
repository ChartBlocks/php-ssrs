<?php

namespace SSRS\Object;

class ItemDefinition extends ObjectAbstract {

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

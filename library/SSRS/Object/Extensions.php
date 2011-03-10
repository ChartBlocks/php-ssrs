<?php

/**
 * SSRS_Object_Abstract
 *
 * @author arron
 */
class SSRS_Object_Extensions extends SSRS_Object_ArrayIterator {

    public $iteratorKey = 'Extension';

    public function init() {
        $this->data['Extension'] = array();
    }

    public function setExtensions(stdClass $items) {
        foreach ($items->Extension AS $item) {
            $this->addExtension(new SSRS_Object_Extension($item));
        }
    }

    public function addExtension(SSRS_Object_Extension $item) {
        $this->data['Extension'][] = $item;
    }

}

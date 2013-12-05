<?php

namespace SSRS\Object;

class Extensions extends ArrayIterator {

    public $iteratorKey = 'Extension';

    public function init() {
        $this->data['Extension'] = array();
    }

    public function setExtensions(stdClass $items) {
        foreach ($items->Extension AS $item) {
            $this->addExtension(new Extension($item));
        }
    }

    public function addExtension(Extension $item) {
        $this->data['Extension'][] = $item;
    }

}

<?php

namespace SSRS\Object;

/**
 * SSRS\Object\Abstract
 *
 * @author arron
 */
class CatalogItems extends ArrayIterator {

    public $iteratorKey = 'CatalogItems';

    public function init() {
        $this->data['CatalogItems'] = array();
    }

    public function setCatalogItems(\stdClass $items) {
        foreach ($items->CatalogItem AS $item) {
            $this->addCatalogItem(new CatalogItem($item));
        }
    }

    public function addCatalogItem(CatalogItem $item) {
        $this->data['CatalogItems'][] = $item;
    }

}

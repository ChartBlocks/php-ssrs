<?php

namespace SSRS\Object;

/**
 * SSRS\Object\Abstract
 *
 * @author arron
 */
class CatalogItems extends ArrayIterator implements \Countable {

    public $iteratorKey = 'CatalogItems';

    public function init() {
        $this->data['CatalogItems'] = array();
    }

    public function count() {
        return count($this->data['CatalogItems']);
    }

    /**
     * 
     * @param \stdClass $items
     * @return \SSRS\Object\CatalogItems
     */
    public function setCatalogItems(\stdClass $items) {
        if (isset($items->CatalogItem)) {
            foreach ($items->CatalogItem AS $item) {
                $this->addCatalogItem(new CatalogItem($item));
            }
        }

        return $this;
    }

    /**
     * 
     * @param \SSRS\Object\CatalogItem $item
     */
    public function addCatalogItem(CatalogItem $item) {
        $this->data['CatalogItems'][] = $item;
    }

}

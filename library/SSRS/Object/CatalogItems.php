<?php

/**
 * SSRS_Object_Abstract
 *
 * @author arron
 */

require_once('ArrayIterator.php');

class SSRS_Object_CatalogItems extends SSRS_Object_ArrayIterator {

    public $iteratorKey = 'CatalogItems';

    public function init() {
        $this->data['CatalogItems'] = array();
    }

    public function setCatalogItems(stdClass $items) {
        foreach ($items->CatalogItem AS $item) {
            $this->addCatalogItem(new SSRS_Object_CatalogItem($item));
        }
    }

    public function addCatalogItem(SSRS_Object_CatalogItem $item) {
        $this->data['CatalogItems'][] = $item;
    }

}

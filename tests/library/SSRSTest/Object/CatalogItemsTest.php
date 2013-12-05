<?php

namespace SSRSTest\Object;

use SSRS\Object\CatalogItems;
use SSRS\Object\CatalogItem;

/**
 * Description of CatalogItemsTest
 *
 * @author arron
 */
class CatalogItemsTest extends \PHPUnit_Framework_TestCase {

    public function testSetCatalogItems() {
        $catalogItem1 = new \stdClass;
        $catalogItem1->ID = '1386fc6d-9c58-489f-adea-081146b62799';
        $catalogItem1->Name = 'Reference Report';
        $catalogItem1->Path = '/Reports/Reference Report';
        $catalogItem1->TypeName = 'Report';
        $catalogItem1->Size = '234413';
        $catalogItem1->CreationDate = '2011-03-03T12:32:57.063';
        $catalogItem1->ModifiedDate = '2011-03-03T12:51:12.05';
        $catalogItem1->CreatedBy = 'MSSQL\WebAccount';
        $catalogItem1->ModifiedBy = 'MSSQL\WebAccount';

        $data = new \stdClass;
        $data->CatalogItems = new \stdClass;
        $data->CatalogItems->CatalogItem = array($catalogItem1);

        $expected = new CatalogItems();
        $expected->addCatalogItem(new CatalogItem($catalogItem1));

        $object = new CatalogItems($data);
        $this->assertEquals($expected, $object);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testPassingInvalidObjectToAddCatalogItemThrowsError() {
        $object = new CatalogItems();
        $object->addCatalogItem(new \stdClass());
    }

    public function testCatalogItemsEmptyArrayOnInit() {
        $object = new CatalogItems();
        $this->assertEquals(array(), $object->CatalogItems);
    }

    public function testAddCatalogItem() {
        $object = new CatalogItems();
        $object->addCatalogItem(new CatalogItem());

        $this->assertEquals(1, count($object->CatalogItems));
    }

    public function testSetCatalogItemsKeepsCurrentItems() {
        $dummy = new \stdClass;
        $dummy->CatalogItem[] = new CatalogItem();

        $object = new CatalogItems();
        $object->setCatalogItems($dummy);
        $this->assertEquals(1, count($object->CatalogItems));

        $object->setCatalogItems($dummy);
        $this->assertEquals(2, count($object->CatalogItems));
    }

}
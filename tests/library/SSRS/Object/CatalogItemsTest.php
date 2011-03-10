<?php

require_once('library/SSRS/Object/Abstract.php');
require_once('library/SSRS/Object/CatalogItems.php');
require_once('library/SSRS/Object/CatalogItem.php');

/**
 * Description of CatalogItemsTest
 *
 * @author arron
 */
class SSRS_Object_CatalogItemsTest extends PHPUnit_Framework_TestCase {

    public function testSetCatalogItems() {
        $catalogItem1 = new stdClass;
        $catalogItem1->ID = '1386fc6d-9c58-489f-adea-081146b62799';
        $catalogItem1->Name = 'Reference Report';
        $catalogItem1->Path = '/Reports/Reference Report';
        $catalogItem1->TypeName = 'Report';
        $catalogItem1->Size = '234413';
        $catalogItem1->CreationDate = '2011-03-03T12:32:57.063';
        $catalogItem1->ModifiedDate = '2011-03-03T12:51:12.05';
        $catalogItem1->CreatedBy = 'MSSQL\WebAccount';
        $catalogItem1->ModifiedBy = 'MSSQL\WebAccount';

        $data = new stdClass;
        $data->CatalogItems = new stdClass;
        $data->CatalogItems->CatalogItem = array($catalogItem1);

        $expected = new SSRS_Object_CatalogItems();
        $expected->addCatalogItem(new SSRS_Object_CatalogItem($catalogItem1));

        $object = new SSRS_Object_CatalogItems($data);
        $this->assertEquals($expected, $object);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testPassingInvalidObjectToAddCatalogItemThrowsError() {
        $object = new SSRS_Object_CatalogItems();
        $object->addCatalogItem(new SSRS_Object_Abstract());
    }

    public function testCatalogItemsEmptyArrayOnInit() {
        $object = new SSRS_Object_CatalogItems();
        $this->assertEquals(array(), $object->CatalogItems);
    }

    public function testAddCatalogItem() {
        $object = new SSRS_Object_CatalogItems();
        $object->addCatalogItem(new SSRS_Object_CatalogItem());

        $this->assertEquals(1, count($object->CatalogItems));
    }

    public function testSetCatalogItemsKeepsCurrentItems() {
        $dummy = new stdClass;
        $dummy->CatalogItem[] = new SSRS_Object_CatalogItem();

        $object = new SSRS_Object_CatalogItems();
        $object->setCatalogItems($dummy);
        $this->assertEquals(1, count($object->CatalogItems));

        $object->setCatalogItems($dummy);
        $this->assertEquals(2, count($object->CatalogItems));
    }

}
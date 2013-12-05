<?php

namespace SSRSTest\Object;

use SSRS\Object\ObjectAbstract;

class AbstractTest extends \PHPUnit_Framework_TestCase {

    public function testSetDataWithStdClass() {
        $data = new \stdClass;
        $data->test1 = 'a';
        $data->test2 = 'b';

        $object = $this->getMockForAbstractClass('\SSRS\Object\ObjectAbstract', array($data));

        $this->assertEquals($data->test1, $object->test1);
        $this->assertEquals($data->test2, $object->test2);
    }

    public function testSetDataWithArray() {
        $data = array('test1' => 'a', 'test2' => 'b');

        $object = $this->getMockForAbstractClass('\SSRS\Object\ObjectAbstract', array($data));

        $this->assertEquals($data['test1'], $object->test1);
        $this->assertEquals($data['test2'], $object->test2);
    }

    public function testSetDataWithNull() {
        $object = $this->getMockForAbstractClass('\SSRS\Object\ObjectAbstract');
        $this->assertEquals(array(), $object->data);
    }

}
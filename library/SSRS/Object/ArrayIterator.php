<?php

namespace SSRS\Object;

/**
 * Description of Iterator
 *
 * @author andrew
 */
class ArrayIterator extends ObjectAbstract implements \Iterator {

    public $iteratorKey = 'Array';

    public function next() {
        return next($this->data[$this->iteratorKey]);
    }

    public function prev() {
        return prev($this->data[$this->iteratorKey]);
    }

    public function key() {
        return key($this->data[$this->iteratorKey]);
    }

    public function current() {
        return current($this->data[$this->iteratorKey]);
    }

    public function valid() {
        return isset($this->data[$this->iteratorKey][$this->key()]);
    }

    public function rewind() {
        return reset($this->data[$this->iteratorKey]);
    }

}

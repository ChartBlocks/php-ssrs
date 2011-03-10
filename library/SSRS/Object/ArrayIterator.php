<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Iterator
 *
 * @author andrew
 */
class SSRS_Object_ArrayIterator extends SSRS_Object_Abstract implements Iterator {

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
<?php

namespace SSRS\Object;

/**
 * Description of Iterator
 *
 * @author andrew
 */
class ArrayIterator extends ObjectAbstract implements \Iterator {

    public $iteratorKey = 'Array';

    public function next(): void {
        next($this->data[$this->iteratorKey]);
    }

    public function prev() {
        return prev($this->data[$this->iteratorKey]);
    }

    public function key(): mixed {
        return key($this->data[$this->iteratorKey]);
    }

    public function current(): mixed {
        return current($this->data[$this->iteratorKey]);
    }

    public function valid(): bool {
        return isset($this->data[$this->iteratorKey][$this->key()]);
    }

    public function rewind(): void {
        reset($this->data[$this->iteratorKey]);
    }

}
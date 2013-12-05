<?php

namespace SSRS\Object;

/**
 * SSRS\Object\Abstract
 *
 * @author arron
 */
abstract class ObjectAbstract {

    public $data = array();

    public function __construct($data = null) {
        $this->init();
        $this->setData($data);
    }

    public function init() {
        
    }

    public function setData($data) {
        $clean = $this->_sanitizeData($data);

        if (is_array($clean)) {
            foreach ($clean AS $key => $value) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    public function __set($key, $value) {
        $methodName = 'set' . ucfirst($key);
        if (method_exists($this, $methodName)) {
            $this->$methodName($value);
        } else {
            $this->data[$key] = $value;
        }
    }

    protected function _sanitizeData($data, $recursive = false) {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if ($recursive && is_array($data)) {
            foreach ($data AS $key => $value) {
                $data[$key] = $this->_sanitizeData($value);
            }
        }

        return $data;
    }

    public function __get($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

}

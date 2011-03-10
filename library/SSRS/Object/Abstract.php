<?php

/**
 * SSRS_Object_Abstract
 *
 * @author arron
 */
class SSRS_Object_Abstract {

    public $data = array();

    public function __construct($data = null) {
        $this->init();
        $this->setData($data);
    }

    public function init() {
        
    }

    public function setData($data) {
        if ($data instanceof stdClass) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            foreach ($data AS $key => $value) {
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

    public function __get($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

}
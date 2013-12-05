<?php

namespace SSRS\Object;

class Properties {

    protected $_properties = array();

    public function __construct($properties = array()) {
        $this->addProperties($properties);
    }

    public function __get($name) {
        return $this->getProperty($name);
    }

    /**
     * 
     * @param array $properties
     */
    public function addProperties(array $properties) {
        foreach ($properties AS $key => $value) {
            if (is_object($value) && isset($value->Name)) {
                $key = $value->Name;
                $value = isset($value->Value) ? $value->Value : null;
            }

            $this->addProperty($key, $value);
        }
    }

    /**
     * 
     * @param string $key
     * @param mixed $value
     * @return \SSRS_Object_Properties
     */
    public function addProperty($key, $value) {
        $this->_properties[$key] = $value;
        return $this;
    }

    /**
     * 
     * @return array
     */
    public function getProperties() {
        return $this->_properties;
    }

    /**
     * 
     * @param string $key
     * @return mixed
     */
    public function getProperty($key) {
        return array_key_exists($key, $this->_properties) ? $this->_properties[$key] : null;
    }

}

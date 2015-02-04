<?php

namespace DNOISE\Component\Configuration;


class ConfigParser {

    public function __construct() {

    }

    public function parse($array, $prefix = '') {

        $result = array();

        foreach($array as $key=>$value) {

            if( $this->is_assoc($value) ) {
                $result = $result + $this->parse($value, $prefix . $key . '.');
            }
            else {
                $result[$prefix . $key] = $value;
            }
        }

        return $result;
    }

    protected function is_assoc($array) {
        return is_array($array) && (array_values($array) !== $array);

    }



}

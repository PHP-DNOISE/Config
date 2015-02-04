<?php

namespace DNOISE\Component\Configuration;


class ConfigParameterBag {

    protected $parameters = array();

    public function __construct() {

    }

    public function add(array $params){

        foreach( $params as $name => $value ){
            $this->set($name, $value);
        }

        $this->update();
    }

    protected function set($name, $value){

        $this->parameters[strtolower($name)] = $value;

    }

    protected function update(){

        foreach($this->parameters as $name => $value){
            $this->parameters[$name] = $this->resolve($value);
        }
    }

    protected function resolve($name){

        if(is_array($name)) return $name;

        if ( preg_match('/^%([^%\s]+)%$/', $name, $match) ) {

            $key = $match[1];

            return $this->get($key);
        }

        $callback =  preg_replace_callback('/%%|%([^%\s]+)%/', function ($match) {

            foreach($match as $m ){

                return $this->resolve($m);

            }

        }, $name );


        return $callback;

    }

    public function has($name){
        return array_key_exists(strtolower($name), $this->parameters);
    }

    public function get($name)
    {
        return $this->has($name) ?  $this->parameters[strtolower($name)] : "%$name%";
    }

    public function toArray()
    {
        return $this->parameters;
    }
}

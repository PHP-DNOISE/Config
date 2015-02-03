<?php

namespace DNOISE\Component\Configuration;


use DNOISE\Component\Configuration\Exception\KeyNotFoundException;
use Symfony\Component\Yaml\Yaml;

class Loader implements LoaderInterface {

    private $config = [];

    public function __construct(array $directories = [] ){

        foreach( $directories as $directory ){
            $this->load($directory);
        }

    }

    public function load($directory){

        $iterator = new \DirectoryIterator($directory);

        /** @var \SplFileInfo $configFile */
        foreach ($iterator as $configFile) {

            if ($configFile->isDir()) {
                continue;
            }

            $this->config =  array_merge($this->config, Yaml::parse(file_get_contents( $configFile->getRealPath() )) );

        }

    }


    public function get($path){

        $keys = explode('.', $path);
        $config = $this->config;

        foreach($keys as $key){

            if( ! array_key_exists($key, $config) ){
                throw new KeyNotFoundException("The configuration key '$path' is not found");
            }

            $config = $config[$key];

        }

        return $config;


    }



}

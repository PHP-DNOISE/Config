<?php

namespace DNOISE\Component\Configuration;


use DNOISE\Component\Configuration\Exception\KeyNotFoundException;
use Symfony\Component\Yaml\Yaml;

class Loader implements LoaderInterface {

    private $config;

    private $parser;

    private $parameterBag;

    public function __construct(array $directories = [] ){

        $this->config = [];
        $this->parameterBag = new ConfigParameterBag();
        $this->parser = new ConfigParser();

        foreach( $directories as $directory ){
            $this->load($directory);
        }

    }

    public function load($directory){

        $iterator = new \DirectoryIterator($directory);

        /** @var \SplFileInfo $configFile */
        foreach ($iterator as $configFile) {

            if ($configFile->isDir() ||  $configFile->getExtension() !== 'yml' ) {
                continue;
            }

            $config = $this->parser->parse( Yaml::parse(file_get_contents( $configFile->getRealPath() )) );
            $this->parameterBag->add( $config );

            $this->config = $this->parameterBag->toArray();

        }

    }

    public function add(array $parameters){

        $this->parameterBag->add($parameters);
        $this->config = $this->parameterBag->toArray();

    }

    public function get($path, $default = null){


        if( ! array_key_exists($path, $this->config) ){

            if( $default !== null ) return $default;
                throw new KeyNotFoundException("The configuration key '$path' is not found");

        }

        return $this->config[$path];


    }



}

<?php

namespace DNOISE\Component\Configuration;

interface LoaderInterface {

    public function load( $directory );
    public function get( $key );
}
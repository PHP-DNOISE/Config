<?php

namespace DNOISE\Component\Configuration;

class FactoryLoader {

   private static $loader;

   private static $directories = array();

   public static function registerDirectory( array $directories = [] ){
       self::$directories = array_merge(self::$directories, $directories);
   }

   public static function factory(){

       if( ! self::$directories  ) return false;

       if( ! self::$loader ){
           self::$loader = new Loader(self::$directories);
       }

       return self::$loader;
   }



}

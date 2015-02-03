<?php

namespace DNOISE\Tests\Component\Configuration;

use DNOISE\Component\Configuration\Loader;
use DNOISE\Tests\TestCase;


/**
 * @covers DNOISE\Component\Configuration\Loader
 */

class LoaderTest extends TestCase
{
    private $loader ;

    public function setUp(){
        $this->loader = new Loader([__DIR__ . '/../../../Resource/', __DIR__ . '/../../../Resource/config' ]);
    }

    /**
     *  @dataProvider getPaths
     */
    public function testGetValueByPathFromYmlConfig($expected, $path){

        $actual = $this->loader->get($path);
        $this->assertEquals($expected, $actual);

    }

    /**
     *  @dataProvider getWithDefault
     */
    public function testGetValuesWithDefaultIfNotExists($expected, $unknown){

        $actual = $this->loader->get($unknown, $expected);
        $this->assertEquals($expected, $actual);

    }

    /**
     * @expectedException        \DNOISE\Component\Configuration\Exception\KeyNotFoundException
     * @expectedExceptionMessage The configuration key 'notload.foo' is not found
     */
    public function testOnlyLoadYamlFilesFromDirectories(){
        $key = 'notload.foo';
        $this->loader->get($key);
    }

    /**
     * @expectedException        \DNOISE\Component\Configuration\Exception\KeyNotFoundException
     * @expectedExceptionMessage The configuration key 'config.exception' is not found
     */
    public function testKeyNotFoundException()
    {
        $key = 'config.exception';
        $this->loader->get($key);
    }

    /**
     * @expectedException        \DNOISE\Component\Configuration\Exception\KeyNotFoundException
     * @expectedExceptionMessage The configuration key 'empty.exception' is not found
     */
    public function testEmptyConfigException(){

        $loader = new Loader();
        $key = 'empty.exception';
        $loader->get($key);
    }

}
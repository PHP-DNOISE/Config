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

    public function testSetNewParameter(){

        $key = 'application.directory';
        $cwd = __DIR__;

        $this->loader->add( [$key => $cwd ] );

        $actual = $this->loader->get($key);
        $this->assertEquals($cwd, $actual);
    }

    /**
     * @dataProvider listResolvedParamters
     */
    public function testResolvedParameters($expected, $path){
        $this->testGetValueByPathFromYmlConfig($expected, $path);
    }

    public function listResolvedParamters(){
        return array(
            ['test', 'doctrine.dbname'],
            ['passwordtest', 'doctrine.password'],
            ['3307', 'doctrine.port'],
        );
    }

    public function testResolveAfterSetting(){

        $expected = 'utf8';

        $this->loader->add(['parameters.charset' => $expected]);

        $actual = $this->loader->get('doctrine.charset');
        $this->assertEquals($expected, $actual);

    }
}
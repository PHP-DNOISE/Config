<?php

namespace DNOISE\Tests\Component\Configuration;

use DNOISE\Component\Configuration\FactoryLoader;
use DNOISE\Tests\TestCase;


/**
 * @covers DNOISE\Component\Configuration\FactoryLoader
 */
class FactoryLoaderTest extends TestCase
{
    /**
     *  @dataProvider getPaths
     */
    public function testBuildFromFactory($expected, $path){

        $loader = FactoryLoader::factory();
        $this->assertInstanceOf('DNOISE\Component\Configuration\LoaderInterface', $loader);

        $actual = $loader->get($path);
        $this->assertEquals($expected, $actual);
    }

}
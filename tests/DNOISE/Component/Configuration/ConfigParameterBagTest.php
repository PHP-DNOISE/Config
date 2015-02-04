<?php

namespace DNOISE\Tests\Component\Configuration;

use DNOISE\Component\Configuration\ConfigParameterBag;
use DNOISE\Tests\TestCase;

/**
 * @covers DNOISE\Component\Configuration\ConfigParameterBag
 */
class ConfigParameterBagTest extends TestCase
{


    public function setUp(){

    }

    /**
     *  @dataProvider parameterList
     */
    public function testParameterResolve(array $expected, array $unresolved ){

        $bag = new ConfigParameterBag();
        $bag->add( $unresolved );

        $actual = $bag->toArray();

        $this->assertEquals($expected, $actual);



    }

    public function parameterList(){

        return array(
            [ ['foo' => 'bar'], ['foo' => 'bar'] ],
            [ ['foo' => 'bar', 'bar' => 'bar'], ['foo' => 'bar', 'bar' => '%foo%'] ],
            [ ['foo' => 'bar', 'bar' => 'barbar'], ['foo' => 'bar', 'bar' => '%foo%bar'] ],
            [ ['foo' => 'foo', 'bar' => 'bar', 'foobar' => 'barfoo'], ['foo' => 'foo', 'bar' => 'bar', 'foobar' => 'bar%foo%'] ],
            [ ['foo' => 'bar', 'bar' => 'bar' ], ['FOO' => 'bar', 'bar' => '%foo%' ] ],
            [ ['foo' => 'BAR', 'bar' => 'barBAR' ], ['FOO' => 'BAR', 'bar' => 'bar%FOO%' ] ],
            [ ['bar' => 'bar', 'foo' => 'bar'], ['bar' => '%foo%', 'foo' => 'bar'] ], //Reverse Order
            [ ['index' => '%undefined%' ] , ['index' => '%undefined%' ] ], //Undefined Index

        );

    }


}
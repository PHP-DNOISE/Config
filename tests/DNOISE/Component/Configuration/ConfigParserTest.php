<?php

namespace DNOISE\Tests\Component\Configuration;

use DNOISE\Component\Configuration\ConfigParser;
use DNOISE\Tests\TestCase;

/**
 * @covers DNOISE\Component\Configuration\ConfigParser
 */
class ConfigParserTest extends TestCase
{

    protected $parser;

    public function setUp()
    {
        $this->parser =  new ConfigParser();
    }

    /**
     *  @dataProvider parameterSimples
     */
    public function testParseAssociativeArray($expected, $data){

        $actual = $this->parser->parse($data);
        $this->assertEquals($expected, $actual);
    }

    public function parameterSimples(){

        return [
            [[ 'config.foo' => 'bar' ], [ 'config' => ['foo' => 'bar'] ] ],
            [[ 'foo' => 'bar' ], ['foo' => 'bar'] ],
            [[ 'config.foo.bar' => 'foo' ],[ 'config' => ['foo' => ['bar' => 'foo']] ] ],
            [[ 'config.isfalse' => false ], [ 'config' => ['isfalse' => false] ] ],
            [[ 'config.istrue' => true], [ 'config' => ['istrue' => true] ] ],
            [[ 'config.array' => ['element1', 'element2', 'element3'] ], [ 'config' => ['array' => ['element1', 'element2', 'element3'] ] ] ],
        ];
    }

    /**
     *  @dataProvider listAssociative
     */
    public function testDetectingAssociativeArray($data){

        $actual = $this->invokeMethod($this->parser, 'is_assoc', [$data] );
        $this->assertTrue($actual);
    }

    public function listAssociative(){

        return [
          [ ['foo' => 'bar'] ],
          [ ['0.1' => 'bar'] ],
          [ [null => 'bar'] ],
          [ [''=> 'bar'] ],
          [ [true => 'bar'] ],
          [[ 1.0 => 'foo']],
          [[ 'foo', 'bar', 'foo' => 'bar' ]],           // Mixed
          [ array_fill_keys(                            // big associative array
              str_split(
                  str_repeat(uniqid('',true),100),
                  3
              ),
              true
          ) ],
          [ array_fill_keys(                            // big misaligned numeric array (=associative)
              range(2, 1000, 3),
              uniqid()
          ) ]

        ];
    }

    /**
     *  @dataProvider listNonAssociative
     */
    public function testDetectingNonAssociativeArray($data){

        $actual = $this->invokeMethod($this->parser, 'is_assoc', [$data] );
        $this->assertFalse($actual);
    }

    public function listNonAssociative(){

        return [
            [['foo', 'bar']],
            [['0', '1']],
            [[ 0 => true ]],
            [[ 0.0 => false ]],
            [ [ array_fill(0, 1000, uniqid()) ] ]
        ];
    }
}
<?php

namespace DNOISE\Tests;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function getPaths(){
        return array(
            ['bar', 'config.foo'],
            ['barfoo', 'config.foobar'],
            ['bar', 'config.second.foo'],
            [['element1', 'element2', 'element3'], 'config.array'],
            [false, 'config.isfalse'],
            [true, 'config.istrue'],
            [false, 'config.default'],
            ['bar', 'multiple.config.foo'],
            ['barfoo', 'multiple.config.foobar'],
            ['bar', 'async.config.foo'],
            ['barfoo', 'async.config.foobar'],
        );
    }

}
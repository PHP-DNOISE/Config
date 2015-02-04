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

    public function getWithDefault(){
        return array(
            ['bar', 'empty.foo'],
            ['barfoo', 'empty.foobar'],
            ['bar', 'empty.second.foo'],
            [['element1', 'element2', 'element3'], 'empty.array'],
            [false, 'empty.isfalse'],
            [true, 'empty.istrue'],
            [false, 'empty.default'],
            ['bar', 'empty.config.foo'],
            ['barfoo', 'empty.config.foobar'],
            ['bar', 'empty.config.foo'],
            ['barfoo', 'empty.config.foobar'],
        );
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
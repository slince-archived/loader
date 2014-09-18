<?php
use Slince\Loader\ClassLoader;

class ClassLoaderTest extends PHPUnit_Framework_TestCase
{
    function testClassMap()
    {
        $classLoader = new ClassLoader();
        $classLoader->registerClassMap('ClassA', __DIR__ . '/Test/ClassA.php')->register();
        $a = new ClassA();
        $this->assertInstanceOf('ClassA', $a);
    }
    function testPsr4()
    {
        $classLoader = new ClassLoader();
        $classLoader->registerPsr4Namespace('Test\\', __DIR__ . '/Test/')->register();
        $b = new Test\Yume\Same\ClassB();
        $this->assertInstanceOf('Test\Yume\Same\ClassB', $b);
    }
    function testPsr0()
    {
        $classLoader = new ClassLoader();
        $classLoader->registerPsr0Namespace('Test', __DIR__ . '/Test/')->register();
        //$classLoader->registerPsr0Namespace('', __DIR__ . '/')->register();
        $c = new Test\Yume_Same_ClassC();
        $this->assertInstanceOf('Test\Yume_Same_ClassC', $c);
        $d = new Test_Yume_Same_ClassD();
        $this->assertInstanceOf('Test_Yume_Same_ClassD', $d);
    }
}
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
        $classLoader->registerNamespace('Test\\Yume\\Same\\', __DIR__ . '/Test/Yume/Same/')->register();
        $b = new Test\Yume\Same\ClassB();
        $this->assertInstanceOf('Test\Yume\Same\ClassB', $b);
    }
    function testPsr0()
    {
        $classLoader = new ClassLoader();
        $classLoader->registerNamespace('Test', __DIR__ . '/Test/')->register();
        $c = new Test\Yume_Same_ClassC();
        $this->assertInstanceOf('Test\Yume_Same_ClassC', $c);
        $d = new Test_Yume_Same_ClassD();
        $this->assertInstanceOf('Test_Yume_Same_ClassD', $d);
    }
    function testPsr4s()
    {
        $classLoader = new ClassLoader();
        $namespaces = array(
            'Test\\Heme\\' => __DIR__ . '/Test/Heme/',
            'Test\\Yume\\' => __DIR__ . '/Test/Yume/'
        );
        $classLoader->registerNamespaces($namespaces, ClassLoader::PSR4)->register();
        $e = new Test\Heme\Difa\ClassE();
        $b = new Test\Yume\Same\ClassB();
        $this->assertInstanceOf('Test\Heme\Difa\ClassE', $e);
        $this->assertInstanceOf('Test\Yume\Same\ClassB', $b);
    }
}
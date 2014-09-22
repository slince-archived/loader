<?php
use Slince\Loader\ClassLoader;
use Slince\Loader\Factory;

class ClassLoaderTest extends PHPUnit_Framework_TestCase
{
    function testClassMap()
    {
        $classLoader = new ClassLoader();
        $classMapLoader = Factory::create(ClassLoader::CLASSMAP);
        $classMapLoader->setClassMap('ClassA', __DIR__ . '/Test/ClassA.php');
        $classLoader->addLoader($classMapLoader)->register();
        $a = new ClassA();
        $this->assertInstanceOf('ClassA', $a);
    }
    function testPsr4()
    {
        $classLoader = new ClassLoader();
        $psr4Loader = Factory::create(ClassLoader::PSR4);
        $psr4Loader->setPrefixPath('Test\\Yume\\Same\\', __DIR__ . '/Test/Yume/Same/');
        $classLoader->addLoader($psr4Loader)->register();
        $b = new Test\Yume\Same\ClassB();
        $this->assertInstanceOf('Test\Yume\Same\ClassB', $b);
    }
    function testPsr0()
    {
        $classLoader = new ClassLoader();
        $psr0Loader = Factory::create(ClassLoader::PSR0);
        $psr0Loader->setPrefixPath('Test', __DIR__ . '/Test/');
        $classLoader->addLoader($psr0Loader)->register();
        $c = new Test\Yume_Same_ClassC();
        $this->assertInstanceOf('Test\Yume_Same_ClassC', $c);
        $d = new Test_Yume_Same_ClassD();
        $this->assertInstanceOf('Test_Yume_Same_ClassD', $d);
    }
    function testPsr4s()
    {
        $classLoader = new ClassLoader();
        $psr4Loader = Factory::create(ClassLoader::PSR4);
        $namespaces = array(
            'Test\\Heme\\' => __DIR__ . '/Test/Heme/',
            'Test\\Yume\\' => __DIR__ . '/Test/Yume/'
        );
        $psr4Loader->setPrefixPaths($namespaces);
        $classLoader->addLoader($psr4Loader)->register();
        $e = new Test\Heme\Difa\ClassE();
        $b = new Test\Yume\Same\ClassB();
        $this->assertInstanceOf('Test\Heme\Difa\ClassE', $e);
        $this->assertInstanceOf('Test\Yume\Same\ClassB', $b);
    }
}
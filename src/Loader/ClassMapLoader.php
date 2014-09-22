<?php
/**
 * slince class loader library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

class ClassMapLoader extends AbstractLoader
{

    /**
     * 类地址映射
     *
     * @var array
     */
    private $_classMap = [];

    function __construct($map = [])
    {
        $this->_classMap = $map;
    }
    /**
     * 设置映射
     *
     * @param string $class            
     * @param string $file            
     */
    function setClassMap($class, $file)
    {
        $this->_classMap[$class] = $file;
    }

    /**
     * 批量设置映射
     *
     * @param array $classMapping            
     */
    function setClassMaps($classMapping)
    {
        $this->_classMap = array_merge($this->_classMap, $classMapping);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Slince\Loader\LoaderInterface::findFile()
     */
    function findFile($class)
    {
        if (isset($this->_classMap[$class])) {
            return $this->_classMap[$class];
        }
        return false;
    }
} 
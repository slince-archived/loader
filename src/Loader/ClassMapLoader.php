<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

use Slince\Loader\LoaderInterface;

class ClassMapLoader implements LoaderInterface
{
    private $_classMap = [];
    
    function setClassMapping($class, $file)
    {
        $this->_classMap[$class] = $file;
    }
    
    function loadClass($class)
    {
        $file = $this->findFile($class);
        include $file;
    }
    
    function findFile($class)
    {
        
    }
} 
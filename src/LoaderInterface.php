<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader;

interface LoaderInterface
{
    /**
     * 加载类
     */ 
    function loadClass($class);
    /**
     * 查找类文件
     * @param string $class
     */
    function findFile($class);
}
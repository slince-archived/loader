<?php
/**
 * slince class loader library
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Loader;

interface LoaderInterface
{

    /**
     * 加载类
     *
     * @return boolean
     */
    function loadClass($class);

    /**
     * 查找类文件
     *
     * @param string $class            
     * @return string|false
     */
    function findFile($class);
}
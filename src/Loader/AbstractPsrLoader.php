<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

abstract class AbstractPsrLoader extends AbstractLoader
{

    /**
     * 命名空间和文件路径的映射
     *
     * @var array
     */
    protected $_prefixPaths = [];
    
    /**
     * 备用目录
     * 
     * @var array
     */
    protected $_fallbackPaths = [];

    /**
     * 设置一个备用目录
     * @param string $path
     */
    function setFallbackPath($path)
    {
        $this->_fallbackPaths[] = $path;
    }
    
    /**
     * 批量设置备用目录
     * 
     * @param array $paths
     */
    function setFallbackPaths($paths)
    {
        $this->_fallbackPaths = array_merge($this->_fallbackPaths, $paths);
    }
    
}
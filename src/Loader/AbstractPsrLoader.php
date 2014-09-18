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
     * 设置前缀和路径映射
     *
     * @param string $prefixPath            
     * @param string|array $path            
     */
    abstract function setPrefixPath($prefixPath, $path);

    /**
     * 批量设置前缀和路径映射
     *
     * @param array $prefixPaths            
     */
    function setPrefixPaths(array $prefixPaths)
    {
        foreach ($prefixPaths as $prefixPath => $path) {
            $this->setPrefixPath($prefixPath, $path);
        }
    }

    /**
     * 设置一个备用目录
     * 
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
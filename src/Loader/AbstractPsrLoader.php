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
    
    protected $_fallbackPaths = [];

    /**
     * 设置前缀和路径映射
     *
     * @param string $prefixPath            
     * @param string|array $path            
     */
    function setPrefixPath($prefixPath, $path)
    {
        if (! is_array($path)) {
            $path = [
                $path
            ];
        }
        $this->_prefixPaths[$prefixPath] = $path;
    }
    
    function setFallbackPath()
    {
        
    }
    
}
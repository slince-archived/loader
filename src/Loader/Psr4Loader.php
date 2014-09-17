<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

class Psr4Loader extends AbstractLoader
{

    /**
     * 命名空间和文件路径的映射
     *
     * @var array
     */
    private $_prefixPaths = [];

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

    /**
     * (non-PHPdoc)
     * 
     * @see \Slince\Loader\LoaderInterface::findFile()
     */
    function findFile($class)
    {
        foreach ($this->_prefixPaths as $prefix => $paths) {
            if (strpos($class, $prefix) === 0) {
                foreach ($paths as $path) {
                    $classFile = str_replace('\\', DIRECTORY_SEPARATOR, str_replace($prefix, $path, $class)) . '.php';
                    if (file_exists($classFile)) {
                        return $classFile;
                    }
                }
            }
        }
        return false;
    }
}
<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

class Psr4Loader extends AbstractPsrLoader
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
        //从设置的命名映射中获取类地址
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
        //如果在映射的地址库中找不到，则从备用目录中获取
        $basePath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        foreach ($this->_fallbackPaths as $path) {
            $classFile = $path . ) . '.php';
        }
        return false;
    }
}
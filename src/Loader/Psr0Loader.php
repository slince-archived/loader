<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

class Psr0Loader extends AbstractPsrLoader
{

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
                    $classFile = str_repace('_', DIRECTORY_SEPARATOR, $classFile);
                    if (file_exists($classFile)) {
                        return $classFile;
                    }
                }
            }
        }
        return false;
    }
}
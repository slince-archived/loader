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
        if (! empty($prefixPath)) {
            if (! is_array($path)) {
                $path = [
                    $path
                ];
            }
            $this->_prefixPaths[$prefixPath] = $path;
        } else {
            $this->setFallbackPath($path);
        }
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
        // 如果在映射的地址库中找不到，则从备用目录中获取
        $basePath = str_replace('_', DIRECTORY_SEPARATOR, str_replace('\\', DIRECTORY_SEPARATOR, $class));
        foreach ($this->_fallbackPaths as $path) {
            $classFile = $path . $basePath . '.php';
            if (file_exists($classFile)) {
                return $classFile;
            }
        }
        return false;
    }
}
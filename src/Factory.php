<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader;

use Slince\Loader\Loader;

class Factory
{

    /**
     * 创建加载对象
     *
     * @param string $loaderType            
     * @throws Exception\LoaderException
     * @return LoaderInterface
     */
    static function create($loaderType)
    {
        $instance = null;
        switch ($loaderType) {
            case ClassLoader::CLASSMAP:
                $instance = new Loader\ClassMapLoader();
                break;
            case ClassLoader::PSR4:
                $instance = new Loader\Psr4Loader();
                break;
            case ClassLoader::PSR0:
                $instance = new Loader\Psr0Loader();
                break;
            default:
                throw new Exception\LoaderException(sprintf('"%s" is unsupported', $loaderType));
        }
        return $instance;
    }
}
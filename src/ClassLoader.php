<?php
/**
 * slince class loader component
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader;

class ClassLoader
{

    /**
     * classmap
     *
     * @var string
     */
    const CLASSMAP = 'ClassMap';

    /**
     * psr4
     *
     * @var string
     */
    const PSR4 = 'Psr4';

    /**
     * psr0
     *
     * @var string
     */
    const PSR0 = 'Psr0';

    /**
     * 自定义加载器
     *
     * @var array
     */
    private $_loaders = [];

    /**
     * 添加一个自定义的加载器
     *
     * @param LoaderInterface $loader            
     * @return ClassLoader
     */
    function addLoader(LoaderInterface $loader)
    {
        $this->_loaders[] = $loader;
        return $this;
    }

    /**
     * 移除自定义的加载器
     * 
     * @param LoaderInterface $loader            
     * @return ClassLoader
     */
    function removeLoader(LoaderInterface $loader)
    {
        if (($position = array_search($loader, $this->_loaders)) !== false) {
            unset($this->_loaders[$position]);
        }
        return $this;
    }

    /**
     * 注册到系统
     */
    function register()
    {
        // 自定义加载器优先
        $callback = function ($class)
        {
            foreach ($this->_loaders as $loader) {
                if ($loader->loadClass($class)) {
                    break;
                }
            }
        };
        spl_autoload_register($callback);
    }
}
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
     * 内部加载器
     *
     * @var array
     */
    private $_selfLoaders = [];

    /**
     * 添加一个自定义的加载器
     *
     * @param LoaderInterface $loader            
     */
    function addLoader(LoaderInterface $loader)
    {
        $this->_loaders[] = $loader;
    }

    /**
     * 移除自定义的加载器
     *
     * @param LoaderInterface $loader            
     * @return boolean
     */
    function removeLoader(LoaderInterface $loader)
    {
        if (($position = array_search($loader, $this->_loaders)) !== false) {
            unset($this->_loaders[$position]);
            return true;
        }
        return false;
    }

    /**
     * 注册一个命名空间
     *
     * @param string $namespace            
     * @param strng|array $path            
     * @return ClassLoader
     */
    function registerNamespace($namespace, $path)
    {
        if (substr($namespace, - 1) === '\\') {
            $this->_getLoader(self::PSR4)->setPrefixPath($namespace, $path);
        } else {
            $this->_getLoader(self::PSR0)->setPrefixPath($namespace, $path);
        }
        return $this;
    }

    /**
     * 批量注册psr命名空间，区分psr类型
     *
     * @param array $namespaces            
     * @param string $loaderType            
     * @return \Slince\Loader\ClassLoader
     */
    function registerNamespaces(array $namespaces, $loaderType = self::PSR4)
    {
        $this->_getLoader($loaderType)->setPrefixPaths($namespaces);
        return $this;
    }

    /**
     * 批量注册psr命名空间，不区分类型
     *
     * @param array $namespaces            
     * @return ClassLoader
     */
    function registerPsrNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace => $path) {
            $this->registerNamespace($namespace, $path);
        }
    }

    /**
     * 注册一个类地址映射
     *
     * @param string $class            
     * @param string $file            
     * @return ClassLoader
     */
    function registerClassMap($class, $file)
    {
        $this->_getLoader(self::CLASSMAP)->setClassMapping($class, $file);
        return $this;
    }

    /**
     * 批量注册映射
     *
     * @param array $classMap            
     * @return \Slince\Loader\ClassLoader
     */
    function registerClassMaps(array $classMap)
    {
        $this->_getLoader(self::CLASSMAP)->setClassMappings($classMap);
        return $this;
    }

    /**
     * 从配置注册
     *
     * @param array $configs            
     * @return ClassLoader
     */
    function registerFromConfig($configs)
    {
        foreach ($configs as $key => $map) {
            if (strcasecmp(self::CLASSMAP, $key) == 0) {
                $this->_getLoader(self::CLASSMAP)->setClassMappings($map);
            } elseif (strcasecmp(self::PSR4, $key) == 0) {
                $this->_getLoader(self::PSR4)->setPrefixPaths($map);
            } elseif (strcasecmp(self::PSR0, $key) == 0) {
                $this->_getLoader(self::PSR0)->setPrefixPaths($map);
            }
        }
        return $this;
    }

    /**
     * 注册到系统
     */
    function register()
    {
        // 自定义加载器优先
        $loaders = array_merge($this->_loaders, $this->_selfLoaders);
        $callback = function ($class) use($loaders)
        {
            foreach ($loaders as $loader) {
                if ($loader->loadClass($class)) {
                    break;
                }
            }
        };
        spl_autoload_register($callback);
    }

    /**
     * 获取内部加载器
     *
     * @param string $loaderType            
     * @return LoaderInterface
     */
    private function _getLoader($loaderType)
    {
        if (! isset($this->_selfLoaders[$loaderType])) {
            $this->_selfLoaders[$loaderType] = Factory::create($loaderType);
        }
        return $this->_selfLoaders[$loaderType];
    }
}
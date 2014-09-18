<?php
/**
 * slince cache component
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
    const TYPE_CLASSMAP = 'ClassMap';

    /**
     * psr4
     *
     * @var string
     */
    const TYPE_PSR4 = 'Psr4';

    /**
     * psr0
     *
     * @var string
     */
    const TYPE_PSR0 = 'Psr0';

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
            $this->_getLoader(self::TYPE_PSR4)->setPrefixPath($namespace, $path);
        } else {
            $this->_getLoader(self::TYPE_PSR0)->setPrefixPath($namespace, $path);
        }
        return $this;
    }

    /**
     * 批量注册命名空间
     *
     * @param array $namespaces            
     * @return ClassLoader
     */
    function registerNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace => $path) {
            $this->registerNamespace($namespace, $path);
        }
        return $this;
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
        $this->_getLoader(self::TYPE_CLASSMAP)->setClassMapping($class, $file);
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
        $this->_getLoader(self::TYPE_CLASSMAP)->setClassMappings($classMap);
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
            if (strcasecmp(ClassLoader::TYPE_CLASSMAP, $key) == 0) {
                $this->_getLoader(self::TYPE_CLASSMAP)->setClassMappings($map);
            } elseif (strcasecmp(ClassLoader::TYPE_PSR4, $key) == 0) {
                $this->_getLoader(self::TYPE_PSR4)->setPrefixPaths($map);
            } elseif (strcasecmp(ClassLoader::TYPE_PSR0, $key) == 0) {
                $this->_getLoader(self::TYPE_PSR0)->setPrefixPaths($map);
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
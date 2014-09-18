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
     * 加载器
     *
     * @var array
     */
    private $_loaders = [];

    /**
     * 从配置注册
     *
     * @param array $configs            
     */
    function register($configs)
    {
        foreach ($configs as $key => $map) {
            if (strcasecmp(ClassLoader::TYPE_CLASSMAP, $key) == 0) {
                foreach ($map as $class => $file) {
                    $this->setClassMap($class, $file);
                }
            } else {
                foreach ($map as $prefix => $path) {
                    $this->setPrefixPath($prefix, $path);
                }
            }
        }
    }

    /**
     * 设置一个classmap
     *
     * @param string $class            
     * @param string $file            
     */
    function setClassMap($class, $file)
    {
        $this->_getLoader(self::TYPE_CLASSMAP)->setClassMapping($class, $file);
        return $this;
    }

    /**
     * 设置一个命名路径前缀
     * 
     * @param string $prefixPath            
     * @param string $path            
     */
    function setPrefixPath($prefixPath, $path)
    {
        $loaderType = self::TYPE_PSR4;
        if (substr($prefix, - 1) !== '\\') {
            $loaderType = self::TYPE_PSR0;
        }
        $this->_getLoader($loaderType)->setPrefixPath($prefixPath, $path);
        return $this;
    }

    function register()
    {
        $callback = function($class){
            foreach ($this->_loaders as $loader) {
                if ($loader->loadClass($class)) {
                    break;
                }
            }
        };
        spl_autoload_register($callback);
    }
    /**
     * 获取加载器
     *
     * @param string $loaderType            
     * @return LoaderInterface
     */
    private function _getLoader($loaderType)
    {
        if (! isset($this->_loaders[$loaderType])) {
            $this->_loaders[$loaderType] = Factory::create($loaderType);
        }
        return $this->_loaders[$loaderType];
    }
}
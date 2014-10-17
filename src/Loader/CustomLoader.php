<?php
/**
 * slince class loader library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

class ClassMapLoader extends AbstractLoader
{

    /**
     * 自定义回调
     *
     * @var \Closure
     */
    private $_callback;

    function __construct(\Closure $callback = null)
    {
        $this->_callback = $callback;
    }

    /**
     * 设置回调函数
     *
     * @param \Closure $callback            
     */
    function setCallback(\Closure $callback)
    {
        $this->_callback = $callback;
    }

    /**
     * 获取当前回调
     * 
     * @return Closure
     */
    function getCallback()
    {
        return $this->_callback;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Slince\Loader\LoaderInterface::findFile()
     */
    function findFile($class)
    {
        return call_user_func($this->_callback, $class);
    }
}
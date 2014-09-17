<?php
/**
 * slince cache library
 * @author Taosikai <taosikai@yeah.net>
 */
namespace Slince\Loader\Loader;

use Slince\Loader\LoaderInterface;

abstract class AbstractLoader implements LoaderInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Slince\Loader\LoaderInterface::loadClass()
     */
    function loadClass($class)
    {
        if (($file = $this->findFile($class)) !== false) {
            include $file;
            return true;
        }
        return false;
    }
}
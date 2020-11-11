<?php

namespace App\Application\Helpers;

trait Singleton 
{
    private static $instance;
    
    private final function __construct() {}
    private final function __clone() {}
    private final function __wakeup() {}
    
    public final static function getInstance() 
    {
        $class = self::getCalledClass();
        if (!self::$instance instanceof $class) {
            self::$instance = self::getNewInstance();
        }
        
        return self::$instance;
    }

    private static function getNewInstance()
    {
        $class = self::getCalledClass();
        return new $class;
    }

    private static function getCalledClass()
    {
        return '\\'.get_called_class();
    }
}
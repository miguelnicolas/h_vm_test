<?php

namespace App\Infrastructure\Storage;

abstract class Storage
{
	private static $instance;

	public static function getInstance(): StorageInterface
	{
        $class = '\\'.get_called_class();
        if (!self::$instance instanceof $class) {
            self::$instance = new $class();
        }

        return self::$instance;
	}
}
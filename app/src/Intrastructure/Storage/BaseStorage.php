<?php

namespace App\Infrastructure\Storage;

abstract class BaseStorage
{
	private static $instance;

	public static function getInstance(): StorageInterface
	{
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
	}
}
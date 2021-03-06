<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Storage\MemoryStorage;

/**
 * @covers App\Infrastructure\Storage\MemoryStorage
 */
final class MemoryStorageTest extends TestCase
{
    private $instance;

    public function setUp(): void
    {
        $this->instance = MemoryStorage::getInstance();
    }
    
    public function test_canBeInitializable()
    {
        self::assertInstanceOf(MemoryStorage::class, $this->instance);
    }

}
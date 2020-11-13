<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\Services\ChangeDispenser;

/**
 * @covers App\Domain\Services\ChangeDispenser
 */
final class ChangeDispenserTest extends TestCase
{
    private $instance;

    public function setUp(): void
    {
        $this->instance = new ChangeDispenser([0.05, 0.10, 0.25, 1]);
    }

    public function test_canBeInitializable()
    {
        self::assertInstanceOf(ChangeDispenser::class, $this->instance);
    }

    /**
     * @covers ::getChange
     */
    public function test_getChange_no_change_returns_array_ok()
    {
        $change = $this->instance->getChange(1.50, 1.50, ['1' => 1, '0.25' => 1, '0.10' => 1, '0.05' => 1]);
        $this->assertIsArray($change);
        $this->assertEmpty($change);
    }

    /**
     * @covers ::getChange
     */
    public function test_getChange_change_returns_025_005_ok()
    {
        $change = $this->instance->getChange(1.20, 1.50, ['1' => 1, '0.25' => 1, '0.10' => 1, '0.05' => 1]);
        $this->assertIsArray($change);
        $this->assertEquals(2,count($change));
        $this->assertTrue(in_array(0.25, $change));
        $this->assertTrue(in_array(0.05, $change));
    }

    /**
     * @covers ::getChange
     */
    public function test_getChange_change_returns_no_enough_change_ok()
    {
        $change = $this->instance->getChange(1.20, 1.50, ['1' => 1, '0.25' => 1, '0.10' => 1]);
        $this->assertEquals(-1, $change);
    }
}
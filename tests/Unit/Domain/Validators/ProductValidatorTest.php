<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\Validators\ProductValidator;

/**
 * @covers App\Domain\Validators\ProductValidator
 */
final class ProductValidatorTest extends TestCase
{
    private $testValues = ['COLA', 'NESTEA', 'PEPSI', 'CHERRY-COKE'];
    private $instance;

    public function setUp(): void
    {
        $this->instance = new ProductValidator($this->testValues);
    }

    public function test_canBeInitializable()
    {
        self::assertInstanceOf(ProductValidator::class, $this->instance);
    }

    /**
     * @covers ::isValidValue
     */
    public function test_isValidValue_validate_product_COLA_true()
    {
        self::assertTrue($this->instance->isValidValue('COLA'));
    }

    /**
     * @covers ::isValidValue
     */
    public function test_isValidValue_validate_coin_CHERRY_SPACE_COKE_false()
    {
        self::assertFalse($this->instance->isValidValue('CHERRY COKE'));
    }

    /**
     * @covers ::getValidValues
     */
    public function test_getValidValues_validate_return_ok()
    {
        self::assertEquals($this->instance->getValidValues(), $this->testValues);
    }
}
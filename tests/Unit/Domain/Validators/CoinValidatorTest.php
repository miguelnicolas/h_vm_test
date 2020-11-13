<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\Validators\CoinValidator;

/**
 * @covers App\Domain\Validators\CoinValidator
 */
final class CoinValidatorTest extends TestCase
{
    private $instance;

    public function setUp(): void
    {
        $this->instance = new CoinValidator([1, 2, 3, 8]);
    }

    public function test_canBeInitializable()
    {
        self::assertInstanceOf(CoinValidator::class, $this->instance);
    }

    /**
     * @covers ::isValidCoin
     */
    public function test_isValidCoin_validate_coin_1_true()
    {
        self::assertTrue($this->instance->isValidCoin(1));
    }

    /**
     * @covers ::isValidCoin
     */
    public function test_isValidCoin_validate_coin_5_false()
    {
        self::assertFalse($this->instance->isValidCoin(5));
    }
}
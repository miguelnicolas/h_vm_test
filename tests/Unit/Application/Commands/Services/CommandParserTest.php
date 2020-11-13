<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Application\Commands\Services\CommandParser;

/**
 * @covers App\Domain\Services\CommandParser
 */
final class CommandParserTest extends TestCase
{
    private $instance;

    public function setUp(): void
    {
        $this->instance = new CommandParser;
    }

    public function test_canBeInitializable()
    {
        self::assertInstanceOf(CommandParser::class, $this->instance);
    }

    /**
     * @covers ::breakDownInput
     */
    public function test_breakDownInput_correct_input_line_ok()
    {
        $line = '1, 1, 0.05, GET-WATER';
        $this->instance->breakDownInput($line);
        self::assertEquals($this->instance->getKeyword(), 'GET');
        self::assertEquals($this->instance->getSubject(), 'WATER');
        self::assertEquals($this->instance->getArguments(), [1, 1, 0.05]);
    }

    /**
     * @covers ::breakDownInput
     */
    public function test_breakDownInput_incorrect_input_line_command_ok()
    {
        $line = 'ASDF - --o';
        $this->instance->breakDownInput($line);
        self::assertEquals($this->instance->getKeyword(), 'ASDF');
        self::assertEmpty($this->instance->getSubject());
        self::assertEmpty($this->instance->getArguments());
    }

    /**
     * @covers ::breakDownInput
     */
    public function test_breakDownInput_incorrect_input_line_numeric_command_ok()
    {
        $line = '1, 2 qwerty';
        $this->instance->breakDownInput($line);
        self::assertEquals($this->instance->getKeyword(), '2 QWERTY');
        self::assertEmpty($this->instance->getSubject());
        self::assertEquals($this->instance->getArguments(), [1]);
    }
}
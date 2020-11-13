<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\Services\Display;

/**
 * @covers App\Domain\Services\Display
 */
final class DisplayTest extends TestCase
{
    private $instance;

    public function setUp(): void
    {
        $this->instance = new Display();
    }

    public function test_canBeInitializable()
    {
        self::assertInstanceOf(Display::class, $this->instance);
    }

    /**
     * @covers ::addMessage
     */
    public function test_addMessage_void_return_ok()
    {
       $response = $this->instance->addMessage('test');
       self::assertEmpty($response);
    }

    /**
     * @covers ::addMessage
     * @covers ::flush
     */
    public function test_addMessage_message_saved_ok()
    {
    	$text = 'test';
       	$this->instance->addMessage($text);
       	$response = $this->instance->flush();
       	self::assertEquals($response, $text);
    }

    /**
     * @covers ::flush
     */
    public function test_flush_empty_ok()
    {
       	$response = $this->instance->flush();
       	self::assertEmpty($response);
    }
}
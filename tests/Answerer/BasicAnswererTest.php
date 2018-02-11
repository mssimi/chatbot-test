<?php declare(strict_types=1);

namespace App\Tests;

use App\Answerer\BasicAnswerer;
use App\Bot\Bot;
use PHPUnit\Framework\TestCase;

final class BasicAnswererTest extends TestCase
{
    /** @var BasicAnswerer */
    private $basicAnswerer;

    protected function setUp(): void
    {
        $botMock = $this->createMock(Bot::class);
        $botMock
            ->expects($this->once())
            ->method('send');

        $botMock
            ->method('message')
            ->willReturn('Hi');

        $botMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $this->basicAnswerer = new BasicAnswerer($botMock);
    }

    public function test(): void
    {
        $this->basicAnswerer->addReply('Hi','Hello');
        $this->basicAnswerer->reply();
    }
}

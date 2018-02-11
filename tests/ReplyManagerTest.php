<?php declare(strict_types=1);

namespace App\Tests;

use App\Answerer\Answerer;
use App\ReplyManager;
use PHPUnit\Framework\TestCase;

class ReplyManagerTest extends TestCase
{
    /** @var ReplyManager */
    private $replyManager;

    protected function setUp(): void
    {
        $this->replyManager = new ReplyManager();
    }

    public function test(): void
    {
        $nlpAnswererMock = $this->createMock(Answerer::class);
        $nlpAnswererMock
            ->expects($this->once())
            ->method('reply');

        $this->replyManager->addAnswerer($nlpAnswererMock);
        $this->replyManager->reply();
    }
}

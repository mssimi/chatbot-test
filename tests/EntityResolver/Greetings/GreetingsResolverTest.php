<?php declare(strict_types=1);

namespace App\Tests\EntityResolver\Greetings;

use App\EntityResolver\Greetings\Adapter\GreetingsAdapter;
use App\EntityResolver\Greetings\GreetingsResolver;
use PHPUnit\Framework\TestCase;

class GreetingsResolverTest extends TestCase
{
    /**
     * @var GreetingsResolver
     */
    private $greetingsResolver;

    protected function setUp(): void
    {
        $greetingsAdapterMock = $this->createMock(GreetingsAdapter::class);
        $greetingsAdapterMock
            ->method('greetings')
            ->willReturn(['Hello']);

        $this->greetingsResolver = new GreetingsResolver($greetingsAdapterMock, 8);
    }

    public function test(): void
    {
        $reply = $this->greetingsResolver->reply(['value' => 'true', 'confidence' => 8]);

        $this->assertSame('Hello', $reply);
    }
}

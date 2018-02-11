<?php declare(strict_types=1);

namespace App\Tests\EntityResolver\Greetings\Adapter;

use App\EntityResolver\Greetings\Adapter\JsonGreetingsAdapter;
use PHPUnit\Framework\TestCase;

class JsonGreetingsAdapterTest extends TestCase
{
    /**
     * @var JsonGreetingsAdapter
     */
    private $jsonGreetingsAdapter;

    protected function setUp(): void
    {
        $this->jsonGreetingsAdapter = new JsonGreetingsAdapter(__DIR__ . '/Config/greetings.json');
    }

    public function test(): void
    {
        $greetings = $this->jsonGreetingsAdapter->greetings();

        $expected = ['Hi', 'Hello'];

        $this->assertSame($greetings, $expected);
    }
}

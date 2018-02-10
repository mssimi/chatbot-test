<?php declare(strict_types=1);

namespace App\EntityResolver\Greetings;

use App\EntityResolver\EntityResolver;
use App\EntityResolver\Greetings\Adapter\JsonGreetingsAdapter;

final class GreetingsResolver implements EntityResolver
{
    /**
     * @var JsonGreetingsAdapter
     */
    private $jsonGreetingsAdapter;

    public function __construct(JsonGreetingsAdapter $jsonGreetingsAdapter)
    {
        $this->jsonGreetingsAdapter = $jsonGreetingsAdapter;
    }

    /**
     * @inheritdoc
     */
    public function reply(?string $value = null, array $extraEntites = []): string
    {
        $greetings = $this->jsonGreetingsAdapter->greetings();

        return $greetings[array_rand($greetings, 1)];
    }
}

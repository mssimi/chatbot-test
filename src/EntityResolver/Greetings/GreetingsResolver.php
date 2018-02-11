<?php declare(strict_types=1);

namespace App\EntityResolver\Greetings;

use App\EntityResolver\EntityResolver;
use App\EntityResolver\Greetings\Adapter\GreetingsAdapter;

final class GreetingsResolver implements EntityResolver
{
    /**
     * @var GreetingsAdapter
     */
    private $jsonGreetingsAdapter;

    /**
     * @var float
     */
    private $minConfidence;

    public function __construct(GreetingsAdapter $jsonGreetingsAdapter, float $minConfidence)
    {
        $this->jsonGreetingsAdapter = $jsonGreetingsAdapter;
        $this->minConfidence = $minConfidence;
    }

    /**
     * @inheritdoc
     */
    public function reply(array $entity, array $extraEntities = []): ?string
    {
        if ($entity['confidence'] < $this->minConfidence) {
            return null;
        }

        $greetings = $this->jsonGreetingsAdapter->greetings();

        return $greetings[array_rand($greetings, 1)];
    }
}

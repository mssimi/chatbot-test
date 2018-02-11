<?php declare(strict_types=1);

namespace App\Answerer;

use App\Bot\Bot;
use App\EntityResolver\EntityResolver;

final class NLPAnswerer implements Answerer
{
    /**
     * @var Bot
     */
    private $bot;

    /**
     * @var EntityResolver[]
     */
    private $entityResolvers = [];

    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
    }

    public function addEntityResolver(string $entity, EntityResolver $entityResolver): void
    {
        $this->entityResolvers[$entity] = $entityResolver;
    }

    public function reply(): void
    {
        if (! $this->bot->isValid()) {
            return;
        }

        foreach ($this->bot->entities() as $entityName => $entity) {
            if (array_key_exists($entityName, $this->entityResolvers) && $reply = $this->entityResolvers[$entityName]->reply($entity[0], $this->bot->entities())) {
                $this->bot->send($reply);
            }
        }
    }
}

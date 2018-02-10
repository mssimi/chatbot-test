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
        foreach ($this->entities() as $entity => $value) {
            if (array_key_exists($entity, $this->entityResolvers)) {
                $this->bot->send($this->entityResolvers[$entity]->reply($this->value($entity), $this->entities()));
            }
        }
    }

    /**
     * @return mixed[]
     */
    private function entities(): array
    {
        return $this->bot->nlp()['entities'];
    }

    /**
     * @return mixed
     */
    private function value(string $entity)
    {
        return $this->bot->nlp()['entities'][$entity][0]['value'];
    }
}

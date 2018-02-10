<?php declare(strict_types=1);

namespace App\Bot;

interface Bot
{
    public function message(): ?string;

    /**
     * @return mixed[]|null
     */
    public function nlp(): ?array;

    public function send(string $reply): void;
}

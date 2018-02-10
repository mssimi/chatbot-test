<?php declare(strict_types=1);

namespace App\Answerer;

use App\Bot\Bot;

final class BasicAnswerer implements Answerer
{
    /**
     * @var Bot
     */
    private $bot;

    /**
     * @var string[]
     */
    private $replies = [];

    public function __construct(Bot $bot)
    {
        $this->bot = $bot;
    }

    public function addReply(string $msg, string $answer): void
    {
        $this->replies[$msg] = $answer;
    }

    public function reply(): void
    {
        if (array_key_exists($this->bot->message(), $this->replies)) {
            $this->bot->send($this->replies[$this->bot->message()]);
        }
    }
}

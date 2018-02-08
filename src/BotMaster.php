<?php declare(strict_types=1);

namespace App;

use App\Bot\Bot;

class BotMaster
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

    public function tryToAnswer(): void
    {
        $this->bot->tryToAnswer($this->replies);
    }
}

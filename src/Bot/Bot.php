<?php declare(strict_types=1);

namespace App\Bot;

interface Bot
{
    /**
     * @param string[] $replies
     */
    public function tryToAnswer(array $replies): void;
}

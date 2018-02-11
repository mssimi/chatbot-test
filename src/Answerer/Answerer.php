<?php declare(strict_types=1);

namespace App\Answerer;

use App\Bot\Bot;

interface Answerer
{
    public function __construct(Bot $bot);

    public function reply(): void;
}

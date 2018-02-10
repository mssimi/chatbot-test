<?php declare(strict_types=1);

namespace App\EntityResolver\Greetings\Adapter;

interface GreetingsAdapter
{
    /**
     * @return string[]
     */
    public function greetings(): array;
}

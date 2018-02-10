<?php declare(strict_types=1);

namespace App\EntityResolver\Reminder\Adapter;

interface ReminderAdapter
{
    public function save(string $reminder): void;
}

<?php declare(strict_types=1);

namespace App\EntityResolver\Reminder\Adapter;

final class TextReminderAdapter implements ReminderAdapter
{
    /**
     * @var string
     */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function save(string $reminder): void
    {
        file_put_contents($this->filename, sprintf("%s\n", $reminder), FILE_APPEND);
    }
}

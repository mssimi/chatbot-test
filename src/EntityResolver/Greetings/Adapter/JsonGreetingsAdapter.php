<?php declare(strict_types=1);

namespace App\EntityResolver\Greetings\Adapter;

use App\Exception\FileNotFoundException;

final class JsonGreetingsAdapter implements GreetingsAdapter
{
    /**
     * @var string
     */
    private $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @inheritdoc
     * @throws FileNotFoundException
     */
    public function greetings(): array
    {
        $json = file_get_contents($this->filename);

        if (! $json) {
            throw new FileNotFoundException('json file not found or not readable');
        }

        return json_decode($json, true);
    }
}

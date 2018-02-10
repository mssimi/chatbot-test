<?php declare(strict_types=1);

namespace App;

use App\Answerer\Answerer;

final class ReplyManager
{
    /**
     * @var Answerer[]
     */
    private $answerers = [];

    public function addAnswerer(Answerer $answerer): void
    {
        $this->answerers[] = $answerer;
    }

    public function reply(): void
    {
        foreach ($this->answerers as $answerer) {
            $answerer->reply();
        }
    }
}

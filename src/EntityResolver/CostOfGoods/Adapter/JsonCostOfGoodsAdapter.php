<?php declare(strict_types=1);

namespace App\EntityResolver\CostOfGoods\Adapter;

use App\Exception\FileNotFoundException;

final class JsonCostOfGoodsAdapter implements CostOfGoodsAdapter
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
    public function products(): array
    {
        $json = file_get_contents($this->filename);

        if (! $json) {
            throw new FileNotFoundException('json file not found or not readable');
        }

        return json_decode($json, true);
    }
}

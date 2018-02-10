<?php declare(strict_types=1);

namespace App\EntityResolver\CostOfGoods\Adapter;

interface CostOfGoodsAdapter
{
    /**
     * @return string[]
     */
    public function products(): array;
}

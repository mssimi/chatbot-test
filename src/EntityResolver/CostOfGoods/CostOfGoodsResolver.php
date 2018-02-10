<?php declare(strict_types=1);

namespace App\EntityResolver\CostOfGoods;

use App\EntityResolver\CostOfGoods\Adapter\CostOfGoodsAdapter;
use App\EntityResolver\EntityResolver;

final class CostOfGoodsResolver implements EntityResolver
{
    /**
     * @var CostOfGoodsAdapter
     */
    private $costOfGoodsAdapter;

    public function __construct(CostOfGoodsAdapter $costOfGoodsAdapter)
    {
        $this->costOfGoodsAdapter = $costOfGoodsAdapter;
    }

    /**
     * @inheritdoc
     */
    public function reply(?string $value = null, array $extraEntites = []): string
    {
        if (array_key_exists($value, $this->costOfGoodsAdapter->products())) {
            return $this->costOfGoodsAdapter->products()[$value];
        }

        return 'This product is not in stock';
    }
}

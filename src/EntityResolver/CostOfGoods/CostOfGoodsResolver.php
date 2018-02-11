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

    /**
     * @var float
     */
    private $minConfidence;

    public function __construct(CostOfGoodsAdapter $costOfGoodsAdapter, float $minConfidence)
    {
        $this->costOfGoodsAdapter = $costOfGoodsAdapter;
        $this->minConfidence = $minConfidence;
    }

    /**
     * @inheritdoc
     */
    public function reply(array $entity, array $extraEntities = []): ?string
    {
        if ($entity['confidence'] < $this->minConfidence) {
            return null;
        }

        if (array_key_exists($entity['value'], $this->costOfGoodsAdapter->products())) {
            return $this->costOfGoodsAdapter->products()[$entity['value']];
        }

        return 'This product is not in stock';
    }
}

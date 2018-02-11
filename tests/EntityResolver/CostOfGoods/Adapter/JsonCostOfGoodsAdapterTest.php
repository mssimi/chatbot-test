<?php declare(strict_types=1);

namespace Tests\EntityResolver\CostOfGoods\Adapter;

use App\EntityResolver\CostOfGoods\Adapter\JsonCostOfGoodsAdapter;
use PHPUnit\Framework\TestCase;

class JsonCostOfGoodsAdapterTest extends TestCase
{
    /**
     * @var JsonCostOfGoodsAdapter
     */
    private $jsonCostOfGoodsAdapter;

    protected function setUp(): void
    {
        $this->jsonCostOfGoodsAdapter = new JsonCostOfGoodsAdapter(__DIR__.'/Config/products.json');
    }

    public function test(): void
    {
        $products = $this->jsonCostOfGoodsAdapter->products();

        $expected = [
            'banana' => '8$',
            'shelf' => '10$',
            'cucumber' => '5$',
        ];

        $this->assertSame($products, $expected);
    }
}

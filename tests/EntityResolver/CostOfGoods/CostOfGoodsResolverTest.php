<?php declare(strict_types=1);

namespace App\Tests\EntityResolver\CostOfGoods;

use App\EntityResolver\CostOfGoods\Adapter\CostOfGoodsAdapter;
use App\EntityResolver\CostOfGoods\CostOfGoodsResolver;
use PHPUnit\Framework\TestCase;

final class CostOfGoodsResolverTest extends TestCase
{
    /**
     * @var CostOfGoodsResolver
     */
    private $costOfGoodsResolver;

    protected function setUp(): void
    {
        $costOfGoodsAdapterMock = $this->createMock(CostOfGoodsAdapter::class);
        $costOfGoodsAdapterMock
            ->method('products')
            ->willReturn([
                'falcon 9' => '1000000000$',
                'falcon heavy' => '3000000000$',
            ]);

        $this->costOfGoodsResolver = new CostOfGoodsResolver($costOfGoodsAdapterMock, 8);
    }

    public function test(): void
    {
        $reply = $this->costOfGoodsResolver->reply(['value' => 'falcon 9', 'confidence' => 8]);

        $this->assertSame('1000000000$', $reply);
    }
}

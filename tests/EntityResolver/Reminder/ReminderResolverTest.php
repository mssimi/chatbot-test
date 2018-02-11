<?php declare(strict_types=1);

namespace App\Tests\EntityResolver\Reminder;

use App\EntityResolver\Reminder\Adapter\ReminderAdapter;
use App\EntityResolver\Reminder\ReminderResolver;
use PHPUnit\Framework\TestCase;

final class ReminderResolverTest extends TestCase
{
    /**
     * @var ReminderResolver
     */
    private $reminderResolver;

    protected function setUp(): void
    {
        $reminderAdapterMock = $this->createMock(ReminderAdapter::class);
        $reminderAdapterMock
            ->expects($this->once())
            ->method('save');

        $this->reminderResolver = new ReminderResolver($reminderAdapterMock, 8);
    }

    public function test(): void
    {
        $reply = $this->reminderResolver->reply(['value' => 'send an email', 'confidence' => 8]);

        $this->assertSame('Setting reminder "send an email"', $reply);
    }
}

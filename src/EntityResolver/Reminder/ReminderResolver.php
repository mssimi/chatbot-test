<?php declare(strict_types=1);

namespace App\EntityResolver\Reminder;

use App\EntityResolver\EntityResolver;
use App\EntityResolver\Reminder\Adapter\ReminderAdapter;
use DateTime;

final class ReminderResolver implements EntityResolver
{
    /**
     * @var ReminderAdapter
     */
    private $reminderAdapter;

    public function __construct(ReminderAdapter $reminderAdapter)
    {
        $this->reminderAdapter = $reminderAdapter;
    }

    /**
     * @inheritdoc
     */
    public function reply(?string $value = null, array $extraEntities = []): string
    {
        if (array_key_exists('datetime', $extraEntities)) {
            $reply = sprintf(
                'Setting reminder "%s" at %s',
                $value,
                (new DateTime($extraEntities['datetime'][0]['value']))->format('Y-m-d H:i:s')
            );
        }

        if (! array_key_exists('datetime', $extraEntities)) {
            $reply = sprintf('Setting reminder "%s"', $value);
        }

        $this->reminderAdapter->save($reply);
        return $reply;
    }
}

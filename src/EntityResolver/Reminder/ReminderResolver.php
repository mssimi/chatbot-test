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

    /**
     * @var float
     */
    private $minConfidence;

    public function __construct(ReminderAdapter $reminderAdapter, float $minConfidence)
    {
        $this->reminderAdapter = $reminderAdapter;
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

        if (array_key_exists('datetime', $extraEntities)) {
            $reply = sprintf(
                'Setting reminder "%s" at %s',
                $entity['value'],
                (new DateTime($extraEntities['datetime'][0]['value']))->format('Y-m-d H:i:s')
            );
        }

        if (! array_key_exists('datetime', $extraEntities)) {
            $reply = sprintf('Setting reminder "%s"', $entity['value']);
        }

        $this->reminderAdapter->save($reply);
        return $reply;
    }
}

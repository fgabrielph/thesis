<?php

namespace App\Support;

class OrderStatus
{
    public const PENDING = 'Pending';

    public const CONFIRMED = 'Confirmed';

    public const ON_DELIVERY = 'On Delivery';

    public const COMPLETED = 'Completed';

    public const RETURNED = 'Return';

    public const CANCELED = 'Canceled';

    private const TRANSITIONS = [
        self::PENDING => [self::CONFIRMED, self::CANCELED],
        self::CONFIRMED => [self::ON_DELIVERY, self::COMPLETED, self::CANCELED],
        self::ON_DELIVERY => [self::COMPLETED, self::RETURNED],
        self::COMPLETED => [self::RETURNED],
        self::RETURNED => [],
        self::CANCELED => [],
    ];

    public static function canTransition(string $from, string $to): bool
    {
        return in_array($to, self::TRANSITIONS[$from] ?? [], true);
    }
}

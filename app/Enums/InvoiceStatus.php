<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case Paid = 'Paid';
    case Sent = 'Sent';
    case Cancelled = 'Cancelled';
    case Draft = 'Draft';
    case Overdue = 'Overdue';

    /**
     * @return array<string>
     */
    public static function toArray(): array
    {
        return [
            self::Paid->value,
            self::Sent->value,
            self::Cancelled->value,
            self::Draft->value,
            self::Overdue->value,
        ];
    }
}

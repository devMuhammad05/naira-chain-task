<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case Paid = 'paid';
    case Sent = 'sent';
    case Cancelled = 'cancelled';
    case Draft = 'draft';
    case Overdue = 'overdue';

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
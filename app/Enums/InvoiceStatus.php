<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case Paid = 'paid';
    case Sent = 'sent';
    case Cancelled = 'cancelled';
    case Draft = 'draft';
    case Overdue = 'overdue';
}

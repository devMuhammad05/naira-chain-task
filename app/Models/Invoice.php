<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'description',
        'billing_name',
        'billing_email',
        'billing_address',
        'total_amount',
        'due_date',
        'issue_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'due_date' => 'date',
            'issue_date' => 'date',
            'status' => InvoiceStatus::class,
        ];
    }

    /**
     * @return BelongsTo<User, self>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

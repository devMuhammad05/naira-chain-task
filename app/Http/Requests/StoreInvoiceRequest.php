<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_number' => ['required', 'string', 'max:255', 'unique:invoices,invoice_number'],
            'description' => ['nullable', 'string'],
            'billing_name' => ['required', 'string', 'max:255'],
            'billing_email' => ['nullable', 'email', 'max:255'],
            'billing_address' => ['nullable', 'string', 'max:500'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'issue_date' => ['required', 'date'],
            'status' => ['required', Rule::enum(InvoiceStatus::class)],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
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
            'invoice_number' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'nullable'],
            'billing_name' => ['sometimes', 'string', 'max:255'],
            'billing_email' => ['sometimes', 'email'],
            'billing_address' => ['sometimes', 'string', 'nullable'],
            'total_amount' => ['sometimes', 'numeric', 'min:0'],
            'due_date' => ['sometimes', 'date'],
            'issue_date' => ['sometimes', 'date'],
            'status' => ['sometimes', Rule::in(InvoiceStatus::toArray())],
        ];
    }
}

<?php

use App\Enums\InvoiceStatus;
use App\Models\User;
use App\Models\Invoice;
use function Pest\Laravel\{actingAs, getJson, postJson, putJson, deleteJson};
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

/**
 * Index
 */
it('lists only the authenticated user invoices', function () {
    $invoiceOwned = Invoice::factory()->create(['user_id' => $this->user->id]);
    $invoiceNotOwned = Invoice::factory()->create();

    $response = getJson('/api/v1/invoices');

    $response->assertOk()
        ->assertJsonFragment(['id' => $invoiceOwned->id])
        ->assertJsonMissing(['id' => $invoiceNotOwned->id]);
});

/**
 * Store
 */
it('creates a new invoice', function () {
    $payload = [
        'invoice_number' => 'INV-001',
        'description' => 'Test invoice',
        'billing_name' => 'John Doe',
        'billing_email' => 'john@example.com',
        'billing_address' => '123 Street',
        'total_amount' => 500,
        'due_date' => now()->addDays(7)->toDateString(),
        'issue_date' => now()->toDateString(),
        'status' => InvoiceStatus::Draft,
    ];

    $response = postJson('/api/v1/invoices', $payload);

    $response->assertCreated()
        ->assertJsonFragment(['invoice_number' => 'INV-001']);

    $this->assertDatabaseHas('invoices', [
        'invoice_number' => 'INV-001',
        'user_id' => $this->user->id,
    ]);
});

/**
 * Show
 */
it('shows an invoice if it belongs to the user', function () {
    $invoice = Invoice::factory()->create(['user_id' => $this->user->id]);

    $response = getJson("/api/v1/invoices/{$invoice->id}");

    $response->assertOk()
        ->assertJsonFragment(['id' => $invoice->id]);
});

it('forbids showing an invoice that does not belong to the user', function () {
    $invoice = Invoice::factory()->create();

    $response = getJson("/api/v1/invoices/{$invoice->id}");

    $response->assertForbidden();
});

/**
 * Update
 */
it('updates an invoice if it belongs to the user', function () {
    $invoice = Invoice::factory()->create(['user_id' => $this->user->id]);

    $payload = ['description' => 'Updated description'];

    $response = putJson("/api/v1/invoices/{$invoice->id}", $payload);

    $response->assertOk()
        ->assertJsonFragment(['description' => 'Updated description']);

    $this->assertDatabaseHas('invoices', [
        'id' => $invoice->id,
        'description' => 'Updated description',
    ]);
});

it('forbids updating an invoice not owned by the user', function () {
    $invoice = Invoice::factory()->create();

    $response = putJson("/api/v1/invoices/{$invoice->id}", [
        'description' => 'Hack update',
    ]);

    $response->assertForbidden();
});

/**
 * Destroy
 */
it('deletes an invoice if it belongs to the user', function () {
    $invoice = Invoice::factory()->create(['user_id' => $this->user->id]);

    $response = deleteJson("/api/v1/invoices/{$invoice->id}");

    $response->assertNoContent();

    $this->assertDatabaseMissing('invoices', [
        'id' => $invoice->id,
    ]);
});

it('forbids deleting an invoice not owned by the user', function () {
    $invoice = Invoice::factory()->create();

    $response = deleteJson("/api/v1/invoices/{$invoice->id}");

    $response->assertForbidden();

    $this->assertDatabaseHas('invoices', [
        'id' => $invoice->id,
    ]);
});

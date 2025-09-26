<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('registers a user successfully', function () {
    $payload = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ];

    $response = postJson('/api/v1/auth/register', $payload);

    $response->assertCreated()
        ->assertJsonStructure([
            'message',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

    assertDatabaseHas('users', [
        'email' => 'john@example.com',
    ]);
});

it('fails registration with duplicate email', function () {
    User::factory()->create([
        'email' => 'duplicate@example.com',
    ]);

    $payload = [
        'name' => 'Jane Doe',
        'email' => 'duplicate@example.com',
        'password' => 'password123',
    ];

    $response = postJson('/api/v1/auth/register', $payload);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

it('logs in a user with correct credentials', function () {
    $user = User::factory()->create([
        'email' => 'login@example.com',
        'password' => Hash::make('password123'),
    ]);

    $payload = [
        'email' => 'login@example.com',
        'password' => 'password123',
    ];

    $response = postJson('/api/v1/auth/login', $payload);

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
                'token',
            ],
        ]);
});

it('fails login with wrong credentials', function () {
    $user = User::factory()->create([
        'email' => 'wrong@example.com',
        'password' => Hash::make('password123'),
    ]);

    $payload = [
        'email' => 'wrong@example.com',
        'password' => 'invalid-password',
    ];

    $response = postJson('/api/v1/auth/login', $payload);

    $response->assertUnauthorized()
        ->assertJson([
            'message' => 'Email or password incorrect',
        ]);
});

it('logs out an authenticated user', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = postJson('/api/v1/logout');

    $response->assertOk()
        ->assertJson([
            'message' => 'Logout successful',
        ]);
});

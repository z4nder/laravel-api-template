<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('should be register user with success', function () {
    User::factory()->count(3)->create();

    Sanctum::actingAs(User::first());

    $this->get(route('users.index'))
        ->assertStatus(200)
        ->assertJsonCount(User::count())
        ->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
                'email_verified_at',
            ],
        ]);
});

it('returns 401 Unauthorized when not authenticated', function () {
    $this->getJson(route('users.index'))->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);
});

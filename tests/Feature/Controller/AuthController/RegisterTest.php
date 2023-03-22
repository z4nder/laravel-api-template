<?php

use App\Models\User;
use function Pest\Laravel\postJson;

it('should be register user with success', function () {
    $password = 'secret@123';
    $params = User::factory()->make()->toArray();
    $params['password'] = $password;
    $params['password_confirmation'] = $password;

    $response = postJson(route('register'), $params);

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type']);

    unset($params['password']);
    unset($params['password_confirmation']);
    $this->assertDatabaseHas('users', $params);
});

it('should be validate required fields', function () {
    $params = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    $response = postJson(route('register'), $params);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});

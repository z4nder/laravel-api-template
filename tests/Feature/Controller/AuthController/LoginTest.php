<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\postJson;

it('should be login with success', function () {
    $password = 'secret@123';

    $user = User::factory([
        'password' => Hash::make($password)
    ])->create();

    $response = postJson(route('login'), [
        'email' => $user->email,
        'password' => $password
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type']);
});

it('should be validate required fields', function () {
    $params = [
        'email' => '',
        'password' => ''
    ];

    $response = postJson(route('login'), $params);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});

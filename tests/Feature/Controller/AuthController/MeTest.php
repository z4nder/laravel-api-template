<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;

it('should be return auth user', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = getJson(route('me'))->assertStatus(200);
    $this->assertEquals($response['id'], $user->id);
    $this->assertEquals($response['name'], $user->name);
    $this->assertEquals($response['email'], $user->email);
    $this->assertEquals($response['email_verified_at'], $user->email_verified_at);
});

it('should be return error with unauthenticated', fn () => getJson(route('me'))->assertStatus(401)->assertSee('Unauthenticated'));

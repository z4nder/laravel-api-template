<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\postJson;

it('should be logout', function () {
    Sanctum::actingAs(User::factory()->create());

    postJson(route('logout'))->assertStatus(200);
});

it('should be return error with unauthenticated', fn () => postJson(route('logout'))->assertStatus(401)->assertSee('Unauthenticated')
);

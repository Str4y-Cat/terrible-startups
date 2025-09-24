<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get('/ideas');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the index page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/ideas');
    $response->assertStatus(200);
});

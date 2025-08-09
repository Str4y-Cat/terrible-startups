<?php

use App\Models\User;

/* -valid data creates a record */
test('valid data creates a idea record', function () {
    $user = User::factory()->create();
    $payload = [
           "title" => "test idea",
           "overview" => "lorem ipsum dolor sit amet",
           "problem_to_solve" => "lorem ipsum dolor sit amet",
           "inspiration" => "lorem ipsum dolor sit amet",
           "solution" => "lorem ipsum dolor sit amet",
           "features" => "lorem ipsum dolor sit amet",
           "target_audience" => "lorem ipsum dolor sit amet",
           "risks" => "lorem ipsum dolor sit amet",
           "challenges" => "lorem ipsum dolor sit amet",
            "rating_questions" => [],
        ];

    $response = $this
    ->actingAs($user)
    ->post(
        '/ideas',
        $payload
    );

    // Assert - database
    $response->assertFound();
    $this->assertDatabaseHas('ideas', [
      "title" => "test idea",
      "overview" => "lorem ipsum dolor sit amet",
      "problem_to_solve" => "lorem ipsum dolor sit amet",
      "inspiration" => "lorem ipsum dolor sit amet",
      "solution" => "lorem ipsum dolor sit amet",
      "features" => "lorem ipsum dolor sit amet",
      "target_audience" => "lorem ipsum dolor sit amet",
      "risks" => "lorem ipsum dolor sit amet",
      "challenges" => "lorem ipsum dolor sit amet",
    ]);

});

/* -invalid data triggers validation errors */
test('Validation fails with invalid data', function () {
    $user = User::factory()->create();
    $payload = [
            'title' => "",
           "overview" => "lorem ipsum dolor sit amet",
           "problem_to_solve" => "lorem ipsum dolor sit amet",
            "rating_questions" => [],
        ];

    $response = $this
    ->actingAs($user)
    ->post(
        '/ideas',
        $payload
    );

    // Assert - database
    $response->assertSessionHasErrors(['title']);
    $this->assertDatabaseCount('ideas', 0);
});

/* -unauthenticated users are redirected to login (get) */
test('Unauthenticated user cannot create a post', function () {

    $payload = [
           "title" => "test idea",
           "overview" => "lorem ipsum dolor sit amet",
        ];

    $response = $this
    ->post(
        '/ideas',
        $payload
    );

    $response->assertRedirect('/login');
    $this->assertDatabaseCount('ideas', 0);

});

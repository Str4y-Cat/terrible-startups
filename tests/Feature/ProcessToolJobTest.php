<?php

use App\Enums\ToolStatus;
use App\Enums\ToolType;
use App\Jobs\ProcessToolJob;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Facades\Http;

/**
* COMPETITOR SEARCH
*/
it('processes the competitor search job correctly', function () {
    $search_response = fixture('openAi/CompetitorSearchResponse');
    Http::fake([
            '*' => Http::response($search_response, 200)
        ]);

    $user = User::factory()->create();
    $idea = $user->ideas()->create([
        'title' => 'test',
        'overview' => 'test overview',
    ]);
    $tool = $idea->tools()->create([
        "type" => ToolType::competitorSearch->value,
        "status" => ToolStatus::processing->value,
    ]);

    // Expect no exception
    expect(fn () => ProcessToolJob::dispatchSync($idea, $tool))
        ->not->toThrow(\Exception::class);
    $tool->refresh();
    expect($tool->status)->toEqual(ToolStatus::complete);
    expect($tool->content)->not()->toBeEmpty();
    expect($tool->tokens_used)->not()->toBe(0);
    expect($tool->model_type)->not()->toBeEmpty();

    $this->assertDatabaseHas('tools', [
       'id' => $tool->id,
       'status' => ToolStatus::complete->value,
    ]);
})->group('job');

/**
* SWOT
*/
it('processes the swot search job correctly', function () {
    $search_response = fixture('openAi/SwotResponse');
    Http::fake([
            '*' => Http::response($search_response, 200)
        ]);

    $user = User::factory()->create();
    $idea = $user->ideas()->create([
        'title' => 'test',
        'overview' => 'test overview',
    ]);
    $tool = $idea->tools()->create([
        "type" => ToolType::swot->value,
        "status" => ToolStatus::processing->value,
    ]);

    // Expect no exception
    expect(fn () => ProcessToolJob::dispatchSync($idea, $tool))
        ->not->toThrow(\Exception::class);
    $tool->refresh();
    expect($tool->status)->toEqual(ToolStatus::complete);
    expect($tool->content)->not()->toBeEmpty();
    expect($tool->tokens_used)->not()->toBe(0);
    expect($tool->model_type)->not()->toBeEmpty();

    $this->assertDatabaseHas('tools', [
       'id' => $tool->id,
       'status' => ToolStatus::complete->value,
    ]);
})->group('job');

/**
* REDDIT COMMUNITY SEARCH
*/
it('processes the reddit search job correctly', function () {
    $search_response = fixture('openAi/CommunitySearchResponse');
    Http::fake([
            '*' => Http::response($search_response, 200)
        ]);

    $user = User::factory()->create();
    $idea = $user->ideas()->create([
        'title' => 'test',
        'overview' => 'test overview',
    ]);
    $tool = $idea->tools()->create([
        "type" => ToolType::redditCommunities->value,
        "status" => ToolStatus::processing->value,
    ]);

    // Expect no exception
    expect(fn () => ProcessToolJob::dispatchSync($idea, $tool))
        ->not->toThrow(\Exception::class);
    $tool->refresh();
    expect($tool->status)->toEqual(ToolStatus::complete);
    expect($tool->content)->not()->toBeEmpty();
    expect($tool->tokens_used)->not()->toBe(0);
    expect($tool->model_type)->not()->toBeEmpty();

    $this->assertDatabaseHas('tools', [
       'id' => $tool->id,
       'status' => ToolStatus::complete->value,
    ]);
})->group('job');

/**
* FAILED API CALL
*/
it('marks tool as failed when API request fails', function () {
    Http::fake(['*' => Http::response(null, 500)]);

    $user = User::factory()->create();
    $idea = $user->ideas()->create(['title' => 'test', 'overview' => 'overview']);
    $tool = $idea->tools()->create([
        'type' => ToolType::competitorSearch->value,
        'status' => ToolStatus::processing->value,
    ]);

    expect(fn () => ProcessToolJob::dispatchSync($idea, $tool))
        ->toThrow(\Exception::class);

    $tool->refresh();
    expect($tool->status)->toEqual(ToolStatus::failed);
})->group('job');

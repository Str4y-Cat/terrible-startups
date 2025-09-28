<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\SyncTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Idea;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /* public function update(UpdateTagRequest $request, Tag $tag) */
    /* { */
    /*     // */
    /* } */

    public function update(Idea $idea, UpdateTagRequest $request): void
    {

        /* $idea->tags()->where() */


        dd('updating tag');
        dd($request->toArray());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea, UpdateTagRequest $request): void
    {
        /* dd($request->toArray()); */
        $tagDelete = $request->validated()['tag'];
        dd($tagDelete);
        $tag = $idea->tags()->where('key', $tagDelete['key'])->where('value', $tagDelete['value'])->first();
        /* $tag = $idea->tags()->where('') */
        dd($request->toArray());
    }

    public function sync(Idea $idea, SyncTagRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $tags = collect($request->validated()['tags'])->map(function ($tag) use ($user) {
            return $user
                ->tags()
                ->where('key', $tag['key'])
                ->where('value', $tag['value'])
                ->first();
        });


        $tagIds = $tags->map(function ($tag) {
            if ($tag) {
                return $tag->id;
            }
        });

        $idea->tags()->sync($tagIds);
        return back()->with('success', 'Tags updated');
        /* dd($request->toArray()); */
    }
}

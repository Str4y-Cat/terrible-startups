<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Idea;
use App\Models\Note;

class NoteController extends Controller
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
    /* public function store(Idea $idea, StoreNoteRequest $request) */
    /* { */
    /*     dd($idea); */
    /*     $idea->note()->create($request->validated()); */
    /* } */
    /**/
    /**
     * Display the specified resource.
     */
    /* public function show(Note $note) */
    /* { */
    /*     // */
    /* } */

    /**
     * Show the form for editing the specified resource.
     */
    /* public function edit(Note $note) */
    /* { */
    /*     // */
    /* } */

    /**
     * Update the specified resource in storage.
     */
    public function update(Idea $idea, UpdateNoteRequest $request): void
    {

        if (is_null($idea->note)) {
            $idea->note()->create($request->validated());
            return;
        }

        $idea->note()->update(
            $request->validated()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea, Note $note)
    {
        //
    }
}

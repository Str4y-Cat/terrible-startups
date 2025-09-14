<?php

namespace App\Http\Controllers;

use App\Enums\Resource;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Tag;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Idea;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $ideas = Idea::query()->where('user_id', $user->id)->get();
        $data = $ideas->map(function ($idea) {
            return $idea->data(Resource::Index);
        });
        /* $ideas = Idea::query()->where('user_id', $user->id)->orderBy("rating", "desc")->paginate(15); */
        return Inertia::render('Dashboard', [
            'ideas' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $tagGroups = $user->tags()
            ->get(['key', 'value']) // only fetch what you need
            ->groupBy('key')
            ->map
            ->pluck('value');


        return Inertia::render('ideas/Create', ['tagGroups' => $tagGroups]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    /* public function store(Request $request) */
    {




        $user = Auth::user();
        $validated = collect($request->validated());




        $ideaArgs = $validated->except(['rating_questions','tags']);

        $rating_questions = $validated['rating_questions'];

        $idea = Idea::create(['user_id' => $user->id, ...$ideaArgs->toArray()]);


        $tag_props = $validated->get('tags');

        foreach ($tag_props as $tag_values) {
            $tag = Tag::firstOrNew($tag_values);
            $idea->tags()->attach($tag);
        }

        /* $idea->tags()->attach(Tag::([])); */


        foreach ($rating_questions as $question) {
            //update or create the user rating table

        }

        return redirect("/ideas/$idea->id");


        /* dd($idea->id); */
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {


        return Inertia::render('ideas/Show', [
            'idea' => $idea->data(Resource::Show),
            'note' => $idea->note()->get(['contents','updated_at'])->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
        dd('Idea Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        //
        $idea->update($request->validated());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        //
        dd('Idea Delete');
    }
}

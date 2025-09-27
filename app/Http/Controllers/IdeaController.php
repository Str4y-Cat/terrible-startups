<?php

namespace App\Http\Controllers;

use App\Enums\Resource;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Models\Question;
use App\Models\Rating;
use App\Models\Tag;
use App\Services\AiService;
use App\Services\DownloadService;
use App\Services\IdeaCreatorService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Idea;

use function GuzzleHttp\json_decode;

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
        return Inertia::render('ideas/Index', [
            'ideas' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        //group the tags by key's
        $tagGroups = $user->tags()
            ->get(['key', 'value']) // only fetch what you need
            ->groupBy('key')
            ->map
            ->pluck('value');

        //get the active questions
        $questions = Question::where('is_active', true)
            ->orderBy('order')
            ->get(['id','heading','description', 'choices']) ;


        return Inertia::render('ideas/Create', ['tagGroups' => $tagGroups,'rating_questions' => $questions]);
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

        $idea = Idea::create(['user_id' => $user->id, ...$ideaArgs->toArray()]);

        $ideaCreator = new IdeaCreatorService($idea);

        $ideaCreator
            ->createTags($validated->get('tags'))
            ->createRating($validated->get('rating_questions'));

        return redirect("/ideas/$idea->id");
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {

        $questions = Question::where('is_active', true)
            ->orderBy('order')
            ->get(['id','heading','description', 'choices']) ;

        $rating_session = $idea->ratings()->latest()->first();

        $answers = [];
        if (!empty($rating_session)) {
            $answers = $rating_session->ratingAnswers()->get(['question_id', 'score']);
        }



        return Inertia::render('ideas/Show', [
            'idea' => $idea->data(Resource::Show),
            'note' => $idea->note()->get(['contents','updated_at'])->first(),
            'rating' => [
                 'questions' => $questions,
                 'answers' => $answers
            ]
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
        $idea->delete();
        return redirect('/ideas');
    }

    public function download(Idea $idea)
    {
        $aiService = new AiService($idea);
        $downloadService = new DownloadService();

        $filename = str_replace(" ", "_", $idea->title);
        $data = $aiService->jsonContext->toArray();

        return $downloadService->exportAsJson($data, $filename);
    }
}

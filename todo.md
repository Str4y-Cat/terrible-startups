# TODO: Laravel Conventions & Issues

This document tracks deviations from Laravel conventions and issues found in the codebase.

---

## Critical Issues

### 1. Bug in Tool Model Relationship
**Problem**: The `idea()` relationship in `app/Models/Tool.php:34` is missing the `$` and references the wrong class.
```php
return this->belongsTo(Tool::class); // ❌ Wrong
```

**Solution**:
```php
return $this->belongsTo(Idea::class);
```

---

### 2. Incomplete Policy Implementation
**Problem**: `app/Policies/IdeaPolicy.php` returns `true` for all methods without checking ownership. Any authenticated user can view/edit/delete any idea.

**Current**:
```php
public function view(User $user, Idea $idea): bool
{
    return true; // ❌ No ownership check
}
```

**Solution**:
```php
public function view(User $user, Idea $idea): bool
{
    return $user->id === $idea->user_id;
}

public function update(User $user, Idea $idea): bool
{
    return $user->id === $idea->user_id;
}

public function delete(User $user, Idea $idea): bool
{
    return $user->id === $idea->user_id;
}
```

---

### 3. Missing Authorization Checks in Controllers
**Problem**: `IdeaController` and `ToolController` don't authorize actions before performing them.

**Solution**: Add authorization checks to controller methods:
```php
public function show(Idea $idea)
{
    $this->authorize('view', $idea);
    // ... rest of method
}

public function update(UpdateIdeaRequest $request, Idea $idea)
{
    $this->authorize('update', $idea);
    // ... rest of method
}

public function destroy(Idea $idea)
{
    $this->authorize('delete', $idea);
    // ... rest of method
}
```

---

## Moderate Issues

### 4. Inconsistent Data Transformation Approach
**Problem**: Mixing multiple patterns for data transformation:
- Models have `data()` methods (Idea model)
- Models have `getData()` methods (Tag model)
- Using dedicated Transformers (ToolDataTransformer)
- Using Data DTOs (ToolData)

**Solution**: Standardize on Laravel API Resources:
```bash
php artisan make:resource IdeaResource
php artisan make:resource TagResource
```

Example:
```php
class IdeaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'rating' => $this->ratings()->first()?->total_score,
            'overview' => $this->overview,
            'date_created' => $this->created_at->toDateString(),
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
```

---

### 5. Wrong ToolType References in ToolController
**Problem**: `app/Http/Controllers/ToolController.php` uses wrong ToolType in queries:
- Line 80: Uses `ToolType::competitorSearch` instead of `ToolType::swot`
- Line 111: Uses `ToolType::competitorSearch` instead of `ToolType::redditCommunities`

**Solution**:
```php
// Line 78-81
return Inertia::render('tools/SwotAnalysis', [
    "idea" => fn () => $idea -> only(['id', 'title']),
    "swots" => fn () => $idea->tools()->where('type', ToolType::swot->value)->get(['status', "content", 'updated_at'])
]);

// Line 109-112
return Inertia::render('tools/RedditCommunities', [
    "idea" => fn () => $idea -> only(['id', 'title']),
    "community_searches" => fn () => $idea->tools()->where('type', ToolType::redditCommunities->value)->get(['status', "content", 'updated_at'])
]);
```

---

### 6. Business Logic in Controllers (ToolController Refactor)
**Problem**: `ToolController` has repetitive code for each tool type. The controller itself notes this needs refactoring (line 21-22).

**Solution**: Refactor to a single method:
```php
public function show(Idea $idea, string $toolType)
{
    $type = ToolType::from($toolType);

    return Inertia::render("tools/{$type->getViewName()}", [
        "idea" => fn () => $idea->only(['id', 'title']),
        "results" => fn () => $idea->tools()
            ->where('type', $type->value)
            ->get(['status', "content", 'updated_at'])
    ]);
}

public function create(Idea $idea, string $toolType)
{
    $type = ToolType::from($toolType);

    $tool = $idea->tools()->create([
        "type" => $type->value,
        "status" => ToolStatus::processing->value,
    ]);

    ProcessToolJob::dispatch($idea, $tool);

    return redirect()->route('tool.show', ['idea' => $idea, 'toolType' => $toolType]);
}
```

---

### 7. Direct Model Queries in Controllers
**Problem**: Controllers contain direct queries that should be scoped or moved to repositories.

Example in `app/Http/Controllers/IdeaController.php:30`:
```php
$ideas = Idea::query()->where('user_id', $user->id)->get();
```

**Solution**: Add query scopes to models:
```php
// In Idea model
public function scopeForUser($query, User $user)
{
    return $query->where('user_id', $user->id);
}

// In controller
$ideas = Idea::forUser($user)->get();
```

Or use a Repository pattern for complex queries.

---

### 8. Service Classes Violate Single Responsibility Principle
**Problem**: `AiService` mixes context building with API calls.

**Solution**: Split into focused classes:
```php
// app/Services/IdeaContextBuilder.php
class IdeaContextBuilder
{
    public function buildJsonContext(Idea $idea): Collection { ... }
    public function buildTextContext(Idea $idea): string { ... }
}

// app/Services/OpenAiClient.php
class OpenAiClient
{
    public function query(string $promptId, string $version, array $variables): Response { ... }
}

// app/Services/AiService.php - orchestrates the two
class AiService
{
    public function __construct(
        protected IdeaContextBuilder $contextBuilder,
        protected OpenAiClient $client
    ) {}
}
```

---

### 9. Missing Return Type Hints in Controllers
**Problem**: Controller methods lack return type declarations.

**Solution**: Add return types:
```php
public function index(): \Inertia\Response
{
    // ...
}

public function store(StoreIdeaRequest $request): \Illuminate\Http\RedirectResponse
{
    // ...
}

public function download(Idea $idea): \Symfony\Component\HttpFoundation\StreamedResponse
{
    // ...
}
```

---

## Minor Issues

### 10. N+1 Query Problem
**Problem**: Multiple places trigger N+1 queries, especially in `Idea::data()` method.

Example in `app/Models/Idea.php:63`:
```php
"rating" => $this->ratings()->first()?->total_score
```

**Solution**: Eager load relationships in controllers:
```php
$ideas = Idea::with(['ratings', 'tags'])
    ->where('user_id', $user->id)
    ->get();
```

---

### 11. Inconsistent Method Naming
**Problem**: Models use both `getData()` (Tag) and `data()` (Idea) for similar purposes.

**Solution**: Standardize on one naming convention (prefer API Resources instead):
- Either use `data()` everywhere
- Or preferably migrate to Laravel API Resources

---

### 12. Magic Numbers Without Explanation
**Problem**: `app/Services/IdeaCreatorService.php:26` checks for size of 1 without explanation:
```php
if (sizeof($questions) == 1) {
    return $this;
}
```

**Solution**: Add constant or comment:
```php
// No rating calculation needed if only one question or no questions provided
if (sizeof($questions) <= 1) {
    return $this;
}
```

---

### 13. Commented-Out Code
**Problem**: Multiple files contain commented code that should be removed:
- `routes/web.php:13-15`
- `app/Http/Controllers/IdeaController.php:34`
- `app/Http/Controllers/ToolController.php:28`
- `routes/auth.php:16-20`

**Solution**: Delete all commented code. Use version control to retrieve old code if needed.

---

### 14. Mixed Quote Styles
**Problem**: Inconsistent use of single and double quotes throughout the codebase.

Example in `app/Models/Idea.php:19-32`:
```php
protected $fillable = [
    'user_id',      // Single quotes
    "rating" ,      // Double quotes
    "overview" ,    // Double quotes
];
```

**Solution**: Use single quotes consistently unless variable interpolation is needed:
```php
protected $fillable = [
    'user_id',
    'rating',
    'overview',
    // ...
];
```

---

### 15. Inconsistent Spacing
**Problem**: Extra spaces after commas throughout fillable arrays.

**Solution**: Run Laravel Pint to auto-fix:
```bash
./vendor/bin/pint
```

---

## Architectural Suggestions

### 16. Consider Repository Pattern
**Problem**: Complex queries are scattered across controllers.

**Solution**: Implement repositories for complex data access:
```php
// app/Repositories/IdeaRepository.php
class IdeaRepository
{
    public function getUserIdeas(User $user, ?string $sortBy = 'created_at'): Collection
    {
        return Idea::where('user_id', $user->id)
            ->with(['tags', 'ratings'])
            ->orderBy($sortBy, 'desc')
            ->get();
    }

    public function getIdeaWithDetails(int $ideaId): ?Idea
    {
        return Idea::with(['tags', 'ratings.ratingAnswers', 'note'])
            ->find($ideaId);
    }
}
```

---

### 17. Unused Job Imports
**Problem**: `app/Http/Controllers/ToolController.php` imports unused job classes:
- `ProcessCompetitorSearchJob` (line 7)
- `ProcessRedditSearchJob` (line 8)
- `ProcessSwotJob` (line 9)

**Solution**: Remove unused imports since you're using the unified `ProcessToolJob`.

---

### 18. Missing Database Transactions
**Problem**: `IdeaCreatorService` performs multiple database operations without transactions.

**Solution**: Wrap multi-step operations in transactions:
```php
use Illuminate\Support\Facades\DB;

public function createTags(array $tags): IdeaCreatorService
{
    DB::transaction(function () use ($tags) {
        foreach ($tags as $tag_values) {
            $tag = Tag::firstOrCreate($tag_values);
            $this->idea->tags()->attach($tag);
        }
    });

    return $this;
}

public function createRating(array $questions): IdeaCreatorService
{
    if (sizeof($questions) <= 1) {
        return $this;
    }

    DB::transaction(function () use ($questions) {
        $questions = collect($questions);

        $questionTotal = $questions->reduce(function ($sum, $cur) {
            return $sum *= $cur['score'];
        }, 1) ?? -1;

        $rating = $this->idea->ratings()->create([
            'idea_id' => $this->idea->id,
            'total_score' => $questionTotal
        ]);

        $rating->ratingAnswers()->createMany($questions);
    });

    return $this;
}
```

---

## Quick Wins Priority Order

1. ✅ Fix Tool model bug (critical) - `app/Models/Tool.php:34`
2. ✅ Fix wrong ToolType references - `app/Http/Controllers/ToolController.php:80, 111`
3. ✅ Add authorization checks to IdeaController
4. ✅ Fix IdeaPolicy to check ownership
5. ✅ Remove all commented code
6. ✅ Add return type hints to controllers
7. ✅ Fix code style (run `./vendor/bin/pint`)
8. ✅ Remove unused imports in ToolController
9. ✅ Add eager loading to prevent N+1 queries
10. ✅ Add database transactions to IdeaCreatorService

---

## Future Considerations

- Migrate to API Resources for consistent data transformation
- Implement repository pattern for complex queries
- Refactor ToolController to eliminate duplication
- Split AiService into focused service classes
- Add proper test coverage for authorization logic

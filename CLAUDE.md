# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

"Terrible Startups" is a Laravel + Vue.js (Inertia.js) application for managing and analyzing startup ideas. Users can create business ideas, rate them through a questionnaire system, and run AI-powered analysis tools (competitor search, SWOT analysis, Reddit community search).

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Vue 3 + TypeScript, Inertia.js for SSR
- **UI**: Tailwind CSS 4, shadcn-vue, Reka UI
- **Database**: SQLite (default), database queue driver
- **Tooling**: Pest for tests, Laravel Pint for linting, Vite for builds

## Development Commands

### Setup
```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

### Development
```bash
# Run full dev environment (server + queue + logs + vite)
composer dev

# Run with SSR
composer dev:ssr

# Individual services
php artisan serve              # Start server
php artisan queue:listen       # Process queue jobs
php artisan pail               # View logs in real-time
npm run dev                    # Start Vite dev server
```

### Testing & Quality
```bash
# Run all tests
composer test
# Or: php artisan test

# Run specific test
php artisan test --filter TestName

# Linting & formatting
npm run lint                   # Lint and fix JS/TS/Vue files
npm run format                 # Format with Prettier
npm run format:check           # Check formatting
./vendor/bin/pint              # PHP code style (Laravel Pint)
```

### Build
```bash
npm run build                  # Build frontend assets
npm run build:ssr              # Build for SSR
```

## Architecture

### Backend Structure

**Core Domain Models:**
- `Idea` - Business ideas with ratings, tags, notes, and tools
- `Tool` - AI analysis results (competitor search, SWOT, Reddit communities)
- `Rating` - Questionnaire-based ratings with answers
- `Tag` - Categorization (industry, business model, customer segment)
- `Note` - User notes attached to ideas

**Key Patterns:**

1. **Async AI Processing**: Tool generation uses queued jobs
   - `ToolController` creates Tool with `processing` status
   - `ProcessToolJob` handles AI API calls via `AiService`
   - `ToolDataTransformer` transforms OpenAI responses
   - Tool status updates: `processing` → `complete` or `failed`

2. **Enums for Type Safety**:
   - `ToolType`: competitorSearch, swot, redditCommunities
   - `ToolStatus`: processing, complete, failed
   - `Resource`: Index, Show (for data transformation contexts)

3. **Data Transformation Layer**:
   - Models have `data(Resource $view)` methods for view-specific serialization
   - `ToolDataTransformer` handles AI response parsing
   - Transformers in `app/Transformers/`

4. **Route Organization**: Routes split by domain
   - `routes/web.php` - main entry point
   - `routes/ideas.php` - idea CRUD + ratings
   - `routes/tools.php` - AI tool endpoints
   - `routes/auth.php` - authentication
   - `routes/settings.php` - user settings
   - `routes/note.php` - notes

### Frontend Structure

**Inertia.js SPA Architecture:**
- Pages in `resources/js/pages/` organized by domain (auth, ideas, tools, settings)
- Shared components in `resources/js/components/`
- Layouts in `resources/js/layouts/`
- Entry point: `resources/js/app.ts`

**Key Frontend Patterns:**
- Composables for shared logic (`resources/js/composables/`)
- Ziggy for type-safe Laravel routes in Vue
- Type definitions in `resources/js/types/`
- shadcn-vue components for UI primitives
- Custom components in `resources/js/components/custom/`

**Navigation & State:**
- History tracking via `useHistory()` composable
- Theme management via `useAppearance()` composable
- Inertia.js handles SPA navigation and state

### AI Integration

The app uses OpenAI via prompt management system (stored in config):
- Prompts identified by ID + version in `config/ai.php`
- Context built from idea data (title, overview, features, tags, etc.)
- Responses processed by `ToolDataTransformer`
- All AI operations are queued for async processing

### Database Queue System

- Queue driver: `database` (configured in `.env`)
- Jobs stored in `jobs` table
- Queue must be running for Tools to process: `php artisan queue:listen`
- Failed jobs logged and Tool status updated to `failed`

## Important Notes

### Email Verification
Recent commits show user verification was added. Users must verify accounts before full access.

### Rating System
Ideas have two rating concepts:
- Legacy `rating` field (capped at 100 on frontend)
- New questionnaire-based `Rating` model with `Questions` and `RatingAnswers`
- Display uses `$idea->ratings()->first()?->total_score` for calculated ratings

### Development Workflow
Always use `composer dev` for development - it runs all required services concurrently with colored output for easy debugging. The queue listener is critical for Tool processing.

### Testing
Use Pest for all tests. Test files in `tests/`. The test command clears config cache before running.

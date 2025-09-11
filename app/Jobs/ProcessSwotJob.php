<?php

namespace App\Jobs;

use App\Enums\ToolStatus;
use App\Models\Idea;
use App\Models\Tool;
use App\Services\AiService;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Utils as GuzzleHttpUtils;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

use function GuzzleHttp\json_encode;

class ProcessSwotJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Idea $idea,
        protected Tool $tool
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $openAiService = new AiService($this->idea);
        $request = $openAiService->getSwot();

        if (!$request->ok()) {

            $this->tool->update([
                "status" => ToolStatus::failed->value
            ]);

            Log::error("ProcessSwotJob: Job failed", [
                "tool_id" => $this->tool->id,
                'response' => $request->body(),
            ]);

            $this->fail();
        }

        $this->tool->update([
            "full_response" => $request->json(),
            "content" => json_decode(Arr::get($request->collect(), 'output.0.content.0.text'), true),
            "status" => ToolStatus::complete->value
        ]);
    }
}

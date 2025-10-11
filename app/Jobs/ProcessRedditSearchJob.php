<?php

namespace App\Jobs;

use App\Enums\ToolStatus;
use App\Enums\ToolType;
use App\Models\Idea;
use App\Models\Tool;
use App\Services\AiService;
use App\Transformers\ToolDataTransformer;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Utils as GuzzleHttpUtils;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

use function GuzzleHttp\json_encode;

class ProcessRedditSearchJob implements ShouldQueue
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
        $response = $openAiService->getRedditCommunities();

        if (!$response->ok()) {

            $this->tool->update([
                "status" => ToolStatus::failed->value
            ]);

            Log::error("ProcessRedditSearchJob: Job failed", [
                "tool_id" => $this->tool->id,
                'response' => $response->body(),
            ]);

            throw new \Exception('ProcessRedditSearchJob failed');
        }

        $toolData = ToolDataTransformer::fromOpenAi($response, ToolType::redditCommunities);

        $this->tool->update($toolData->asArray());
    }
}

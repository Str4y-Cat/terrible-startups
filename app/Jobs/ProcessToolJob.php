<?php

namespace App\Jobs;

use App\Enums\ToolStatus;
use App\Models\Idea;
use App\Models\Tool;
use App\Services\AiService;
use App\Transformers\ToolDataTransformer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessToolJob implements ShouldQueue
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

        /* $openAiService = new AiService($this->idea); */
        /* $response = $openAiService->getCompetitorAnalysis(); */

        $response = AiService::getResponseFor($this->tool->type, $this->idea);

        if (!$response->ok()) {


            $this->tool->update([
                "status" => ToolStatus::failed->value
            ]);

            Log::error("Process tool job: Job failed", [
                "tool_id" => $this->tool->id,
                "tool_type" => $this->tool->type,
                'response' => $response->body(),
            ]);


            throw new \Exception('ProcessToolJob failed');
        }

        try {

            $toolData = ToolDataTransformer::fromOpenAi($response, $this->tool->type);
        } catch (Throwable $err) {

            $this->tool->update([
                "status" => ToolStatus::failed->value
            ]);

            throw $err;
        }

        $this->tool->update(
            [
                ...$toolData->asArray(),
                'status' => ToolStatus::complete
            ]
        );
    }
}

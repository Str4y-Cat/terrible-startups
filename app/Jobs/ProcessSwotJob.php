<?php

namespace App\Jobs;

use App\Enums\ToolStatus;
use App\Enums\ToolType;
use App\Models\Idea;
use App\Models\Tool;
use App\Services\AiService;
use App\Transformers\ToolDataTransformer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use ToolData;

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
        $response = $openAiService->getSwot();

        if (!$response->ok()) {

            $this->tool->update([
                "status" => ToolStatus::failed->value
            ]);

            Log::error("ProcessSwotJob: Job failed", [
                "tool_id" => $this->tool->id,
                'response' => $response->body(),
            ]);

            throw new \Exception('ProcessSwotJob failed');
        }

        $toolData = ToolDataTransformer::fromOpenAi($response, ToolType::swot);

        $this->tool->update(
            $toolData->asArray()
        );

        $this->tool->update(
            ["status" => ToolStatus::complete->value]
        );
    }
}

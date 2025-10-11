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

use function GuzzleHttp\json_encode;

class ProcessCompetitorSearchJob implements ShouldQueue
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

        //REFACTOR:
        //look at combining all the jobs into one. We have the same
        //content across all of them, except for the ai service query, and
        //the transform.
        //This could be handled with a refactor to aiService to return based on
        //the tool type given to to
        //i.e AiService::query(Tooltype::competitorSearch);

        $openAiService = new AiService($this->idea);
        $response = $openAiService->getCompetitorAnalysis();


        if (!$response->ok()) {

            $this->tool->update([
                "status" => ToolStatus::failed->value
            ]);

            Log::error("ProcessCompetitorSearchJob: Job failed", [
                "tool_id" => $this->tool->id,
                'response' => $response->body(),
            ]);

            throw new \Exception('ProcessSwotJob failed');
        }

        $toolData = ToolDataTransformer::fromOpenAi($response, ToolType::competitorSearch);

        $this->tool->update($toolData->asArray());
    }
}

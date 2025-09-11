<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAi
    |--------------------------------------------------------------------------
    |
    | api key for openAI
    | REFACTOR: update this. move it to its own config file.
    |           have seperate things for each prompt
    |
    |
    |
    */

    'openai_key' => env('OPENAI_KEY'),
    'openai_url' => env('OPENAI_URL', 'https://api.openai.com/v1/responses'),

    // COMPETITOR ANALYSIS
    'openai_competitor_search_prompt_id' => env('OPENAI_COMP_SEARCH_PROMT_ID', 'pmpt_68b437cd4bfc8196a576e741fdecb161087b063f5cf348a0'),
    'openai_competitor_search_prompt_version' => env('OPENAI_COMP_SEARCH_PROMT_VERSION', '6'),


    // SWOT
    'openai_SWOT_prompt_id' => env('OPENAI_SWOT_PROMT_ID', 'pmpt_68c26aa743f88196a80bc6fe06b54f0608145998f4d33b5e'),
    'openai_SWOT_prompt_version' => env('OPENAI_SWOT_PROMT_VERSION', '2'),
];

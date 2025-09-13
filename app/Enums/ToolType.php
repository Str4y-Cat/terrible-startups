<?php

namespace App\Enums;

enum ToolType: string
{
    case competitorSearch = "competitor-search";
    case redditCommunities = "reddit-communities";
    case riskAnalysis =  "risk-analysis";
    case feedback = "feedback";
    case swot = "swot";
}

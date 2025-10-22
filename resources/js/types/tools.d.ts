export interface Tool {
    idea: { id: string; title: string };
    tool_results: ToolResult[];
    tool_type: ToolType;
}

export type ToolType = 'competitor-search' | 'swot' | 'reddit-communities';

export interface ToolResult {
    status: 'processing' | 'complete' | 'failed'; // matches your ToolStatus enum
    content: CompetitorSearchContent | SwotAnalysisContent | CompetitorSearchContent;
    updated_at: string;
}

// COMPETITOR ANALYSIS

export interface CompetitorSearchContent {
    competitors: Competitor[];
    indirect_competitors: Competitor[];
}

export interface Competitor {
    name: string;
    description: string;
    strengths: string;
    weaknesses: string;
    market_position: string;
    target_audience: string;
    pricing: string;
    website: string;
    regions: string;
}

// SWOT

export interface SwotAnalysisContent {
    SWOT: {
        Threats: SWOTCategory;
        Strengths: SWOTCategory;
        Weaknesses: SWOTCategory;
        Opportunities: SWOTCategory;
    };
    Research: string;
    BusinessIdeaSummary: string;
}

export interface SWOTCategory {
    Points: string[];
    Reasoning: string;
}

// COMMUNITY

export interface CommunityAnalysisContent {
    communities: Community[];
    business_idea_analysis: string;
}

export interface Community {
    name: string;
    type?: string;
    description: string;
    link_or_access: string;
    relevance_reasoning: string;
}

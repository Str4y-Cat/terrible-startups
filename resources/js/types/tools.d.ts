// COMPETITOR ANALYSIS
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

export interface CompetitorSearchContent {
    competitors: Competitor[];
    indirect_competitors: Competitor[];
}

export interface CompetitorSearch {
    status: 'processing' | 'complete' | 'failed'; // matches your ToolStatus enum
    content: CompetitorSearchContent;
    updated_at: string;
}

// SWOT
export interface SwotAnalysis {
    status: 'processing' | 'complete' | 'failed'; // matches your ToolStatus enum
    content: SwotAnalysisContent;
    updated_at: string;
}

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

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

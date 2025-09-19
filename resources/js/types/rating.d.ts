// types/rating.ts

// Stores answers, keyed by question ID
export type RatingFormData = Record<string, number | undefined>;

export interface RatingChoice {
    value: number;
    label: string;
    description: string;
}

export interface RatingQuestion {
    id: string;
    heading: string;
    description: string;
    choices: RatingChoice[];
}

export interface RatingSystemProps {
    open?: boolean;
    questions: RatingQuestion[];
    disabled: boolean;
    processing: boolean;
    title?: string;
}

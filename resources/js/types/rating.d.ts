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
    modelValue?: boolean;
    answers?: RatingAnswer[];
    questions: RatingQuestion[];
    disabled: boolean;
    processing: boolean;
    title?: string;
}

export interface Rating {
    questions: RatingQuestion[];
    answers: RatingAnswer[];
}

export interface RatingAnswer {
    question_id: number;
    score: number | null;
}

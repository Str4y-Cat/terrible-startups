export interface Tag {
    key: string;
    value: string;
}
// export interface Idea {
//     title: string;
//     rating: number;
//     overview: string;
//     id: string;
//     date_created: string;
//     tags: Tag[];
// }

export interface Idea {
    title: string;
    rating: number;
    id: number;
    overview: string;
    date_created: string;
    tags: Tag[];
    details?: IdeaDetails;
}

interface IdeaDetails {
    problem_to_solve: string;
    inspiration: string;
    solution: string;
    features: string[];
    target_audience: string[];
    risks: string[];
    challenges: string[];
}

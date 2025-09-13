export interface Tag {
    key: string;
    value: string;
}
export interface Idea {
    title: string;
    id: string;
    date_created: string;
    rating: number;
    tags: Tag[];
}

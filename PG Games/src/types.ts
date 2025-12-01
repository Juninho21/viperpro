export interface Game {
    id: string;
    name: string;
    provider: string;
    category: 'popular' | 'slot' | 'cartas';
    url: string;
    thumbnail: string;
}

export interface Category {
    id: 'popular' | 'slot' | 'cartas';
    label: string;
    icon: string;
}

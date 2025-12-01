import type { Game } from './types';

export const games: Game[] = [
    // Popular (Fortune Series & Top Hits from Screenshot)
    {
        id: 'fortune-tiger',
        name: 'Fortune Tiger',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_fortunetiger/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'fortune-tiger'
    },
    {
        id: 'fortune-rabbit',
        name: 'Fortune Rabbit',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_fortunerabbit/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'fortune-rabbit'
    },
    {
        id: 'fortune-mouse',
        name: 'Fortune Mouse',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_fortunemouse/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'fortune-mouse'
    },
    {
        id: 'pinata-wins',
        name: 'Pinata Wins',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_phoenixrises/', // Placeholder URL if not provided
        thumbnail: 'pinata-wins'
    },

    // Other Games from User List
    {
        id: 'fortune-ox',
        name: 'Fortune Ox',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_fortuneox/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'fortune-ox'
    },
    {
        id: 'phoenix-rises',
        name: 'Phoenix Rises',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_phoenixrises/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'phoenix-rises'
    },
    {
        id: 'queen-bounty',
        name: 'Queen Of Bounty',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_queenofbounty/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'queen-bounty'
    },
    {
        id: 'fortune-panda',
        name: 'Fortune Panda',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_fortunepanda/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'fortune-panda'
    },
    {
        id: 'bikini-paradise',
        name: 'Bikini Paradise',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_bikiniparadise/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'bikini-paradise'
    },
    {
        id: 'hood-vs-wolf',
        name: 'Hood Vs Wolf',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_hoodvswoolf/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'hood-vs-wolf'
    },
    {
        id: 'jack-frost',
        name: "Jack Frost's Winter",
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_jackfrost/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'jack-frost'
    },
    {
        id: 'songkran-party',
        name: 'Songkran Splash',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_songkranparty/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'songkran-party'
    },
    {
        id: 'treasures-aztec',
        name: 'Treasures Of Aztech',
        provider: 'PG Soft',
        category: 'popular',
        url: 'https://pgsoft.whitepel.com/games/f_treasuresofaztec/index.html?token=cb956ff5-d75f-41a2-93db-10266ab1b37f',
        thumbnail: 'treasures-aztec'
    }
];

export const gameThumbnails: Record<string, string> = {
    'fortune-tiger': 'linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 50%, #c44569 100%)',
    'fortune-rabbit': 'linear-gradient(135deg, #a29bfe 0%, #6c5ce7 50%, #5f27cd 100%)',
    'fortune-snake': 'linear-gradient(135deg, #fd79a8 0%, #e84393 50%, #d63031 100%)',
    'fortune-dragon': 'linear-gradient(135deg, #00b894 0%, #00cec9 50%, #0984e3 100%)',
    'fortune-ox': 'linear-gradient(135deg, #fdcb6e 0%, #e17055 50%, #d63031 100%)',
    'fortune-panda': 'linear-gradient(135deg, #74b9ff 0%, #0984e3 50%, #6c5ce7 100%)',
    'ganesha-gold': 'linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 50%, #e17055 100%)',
    'pinata-wins': 'linear-gradient(135deg, #ff7675 0%, #fd79a8 50%, #fdcb6e 100%)',
    'double-fortune': 'linear-gradient(135deg, #fab1a0 0%, #ff7675 50%, #fd79a8 100%)',
    'bikini-paradise': 'linear-gradient(135deg, #74b9ff 0%, #a29bfe 50%, #fd79a8 100%)',
    'hood-vs-wolf': 'linear-gradient(135deg, #55efc4 0%, #00b894 50%, #00cec9 100%)',
    'jack-frost': 'linear-gradient(135deg, #81ecec 0%, #74b9ff 50%, #a29bfe 100%)',
    'phoenix-rises': 'linear-gradient(135deg, #ff7675 0%, #fd79a8 50%, #e17055 100%)',
    'queen-bounty': 'linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 50%, #fab1a0 100%)',
    'songkran-party': 'linear-gradient(135deg, #55efc4 0%, #81ecec 50%, #74b9ff 100%)',
    'treasures-aztec': 'linear-gradient(135deg, #fdcb6e 0%, #e17055 50%, #d63031 100%)',
    'fortune-mouse': 'linear-gradient(135deg, #a29bfe 0%, #fd79a8 50%, #fdcb6e 100%)'
};

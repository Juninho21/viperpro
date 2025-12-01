import { useState } from 'react';
import { Header } from './components/Header';
import { Banner } from './components/Banner';
import { CategoryTabs } from './components/CategoryTabs';
import { GameGrid } from './components/GameGrid';
import { Modal } from './components/Modal';
import { games } from './games';
import type { Game } from './types';

function App() {
  const [selectedGame, setSelectedGame] = useState<Game | null>(null);
  const [orderedGames, setOrderedGames] = useState<Game[]>(games);

  const handleReorder = (dragIndex: number, dropIndex: number) => {
    const newGames = [...orderedGames];
    const [draggedGame] = newGames.splice(dragIndex, 1);
    newGames.splice(dropIndex, 0, draggedGame);
    setOrderedGames(newGames);
  };

  return (
    <div className="app">
      <Header />
      <Banner />

      <CategoryTabs />

      <GameGrid
        games={orderedGames}
        onGameClick={setSelectedGame}
        onReorder={handleReorder}
      />

      <Modal
        isOpen={!!selectedGame}
        onClose={() => setSelectedGame(null)}
        gameUrl={selectedGame?.url || ''}
      />
    </div>
  );
}

export default App;

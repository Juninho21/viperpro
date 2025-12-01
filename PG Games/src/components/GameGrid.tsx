import React, { useState } from 'react';
import type { Game } from '../types';
import { gameThumbnails } from '../games';

interface GameGridProps {
    games: Game[];
    onGameClick: (game: Game) => void;
    onReorder?: (dragIndex: number, dropIndex: number) => void;
}

export const GameGrid: React.FC<GameGridProps> = ({ games, onGameClick, onReorder }) => {
    const [draggedIndex, setDraggedIndex] = useState<number | null>(null);
    const [dragOverIndex, setDragOverIndex] = useState<number | null>(null);

    const handleDragStart = (e: React.DragEvent, index: number) => {
        setDraggedIndex(index);
        e.dataTransfer.effectAllowed = 'move';
    };

    const handleDragOver = (e: React.DragEvent, index: number) => {
        e.preventDefault();
        setDragOverIndex(index);
    };

    const handleDrop = (e: React.DragEvent, dropIndex: number) => {
        e.preventDefault();
        if (draggedIndex !== null && draggedIndex !== dropIndex && onReorder) {
            onReorder(draggedIndex, dropIndex);
        }
        setDraggedIndex(null);
        setDragOverIndex(null);
    };

    const handleDragEnd = () => {
        setDraggedIndex(null);
        setDragOverIndex(null);
    };

    return (
        <>
            <div className="section-header" style={{
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
                padding: '0 1rem 1rem',
                marginTop: '1rem'
            }}>
                <div className="section-title" style={{
                    display: 'flex',
                    alignItems: 'center',
                    gap: '0.5rem',
                    fontSize: '1.2rem',
                    fontWeight: 700,
                    color: 'var(--kto-text)'
                }}>
                    <span className="section-icon">🔥</span>
                    <span>Jogos em Destaque</span>
                </div>
                <div className="section-actions" style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                    <button style={{
                        background: 'transparent',
                        border: '1px solid var(--kto-border)',
                        color: 'var(--kto-text)',
                        padding: '0.2rem 0.8rem',
                        fontSize: '0.9rem'
                    }}>
                        Ver todos ({games.length})
                    </button>
                </div>
            </div>

            <div className="games-grid" style={{
                display: 'grid',
                gridTemplateColumns: 'repeat(auto-fill, minmax(140px, 1fr))',
                gap: '1rem',
                padding: '0 1rem',
                marginBottom: '2rem'
            }}>
                {games.map((game, index) => (
                    <div
                        key={game.id}
                        className="game-card"
                        draggable={!!onReorder}
                        onDragStart={(e) => handleDragStart(e, index)}
                        onDragOver={(e) => handleDragOver(e, index)}
                        onDrop={(e) => handleDrop(e, index)}
                        onDragEnd={handleDragEnd}
                        onClick={() => onGameClick(game)}
                        style={{
                            position: 'relative',
                            borderRadius: '8px',
                            overflow: 'hidden',
                            cursor: onReorder ? 'grab' : 'pointer',
                            aspectRatio: '3/4',
                            backgroundColor: 'var(--kto-dark-gray)',
                            transition: 'transform 0.2s ease',
                            border: dragOverIndex === index ? '2px solid var(--kto-red)' : '1px solid var(--kto-border)',
                            opacity: draggedIndex === index ? 0.5 : 1,
                            transform: dragOverIndex === index ? 'scale(0.95)' : 'scale(1)'
                        }}
                        onMouseEnter={(e) => {
                            if (draggedIndex === null) {
                                e.currentTarget.style.transform = 'scale(1.05)';
                            }
                        }}
                        onMouseLeave={(e) => {
                            if (draggedIndex === null && dragOverIndex !== index) {
                                e.currentTarget.style.transform = 'scale(1)';
                            }
                        }}
                    >
                        <img
                            src={`/assets/images/${game.thumbnail}.png`}
                            alt={game.name}
                            style={{
                                width: '100%',
                                height: '100%',
                                objectFit: 'cover',
                                display: 'block',
                                pointerEvents: 'none'
                            }}
                            onError={(e) => {
                                const target = e.currentTarget;
                                target.style.display = 'none';
                                target.parentElement!.style.background = gameThumbnails[game.thumbnail] || 'linear-gradient(135deg, #333 0%, #000 100%)';
                            }}
                        />

                        <div className="game-info" style={{
                            position: 'absolute',
                            bottom: 0,
                            left: 0,
                            right: 0,
                            padding: '0.5rem',
                            background: 'linear-gradient(to top, rgba(0,0,0,0.9), transparent)',
                            color: 'white',
                            fontSize: '0.9rem',
                            fontWeight: 600,
                            pointerEvents: 'none'
                        }}>
                            {game.name}
                        </div>
                    </div>
                ))}
            </div>
        </>
    );
};

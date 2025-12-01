import React, { useEffect, useState } from 'react';

interface ModalProps {
    isOpen: boolean;
    onClose: () => void;
    gameUrl: string;
}

export const Modal: React.FC<ModalProps> = ({ isOpen, onClose, gameUrl }) => {
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const handleEsc = (e: KeyboardEvent) => {
            if (e.key === 'Escape') onClose();
        };

        if (isOpen) {
            document.body.style.overflow = 'hidden';
            window.addEventListener('keydown', handleEsc);
            setLoading(true); // Reset loading when modal opens
        } else {
            document.body.style.overflow = 'auto';
        }

        return () => {
            window.removeEventListener('keydown', handleEsc);
            document.body.style.overflow = 'auto';
        };
    }, [isOpen, onClose]);

    if (!isOpen) return null;

    return (
        <div className="game-modal active" onClick={onClose} style={{
            position: 'fixed',
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
            background: 'rgba(0,0,0,0.95)',
            zIndex: 10000,
            animation: 'fadeIn 0.3s ease-out',
            display: 'flex',
            flexDirection: 'column'
        }}>
            <div className="modal-header" style={{ padding: '15px', display: 'flex', justifyContent: 'flex-end' }}>
                <button
                    className="close-btn"
                    onClick={onClose}
                    style={{
                        background: 'rgba(255,255,255,0.1)',
                        border: 'none',
                        color: 'white',
                        width: '40px',
                        height: '40px',
                        borderRadius: '50%',
                        fontSize: '24px',
                        cursor: 'pointer',
                        transition: 'all 0.3s ease'
                    }}
                >✕</button>
            </div>

            {/* Loading Spinner */}
            {loading && (
                <div style={{
                    position: 'absolute',
                    top: '50%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    gap: '20px',
                    zIndex: 1
                }}>
                    <div className="spinner" style={{
                        width: '60px',
                        height: '60px',
                        border: '4px solid rgba(255,255,255,0.1)',
                        borderTop: '4px solid var(--kto-red)',
                        borderRadius: '50%',
                        animation: 'spin 1s linear infinite'
                    }} />
                    <div style={{
                        color: 'white',
                        fontSize: '16px',
                        fontWeight: 600
                    }}>Carregando jogo...</div>
                </div>
            )}

            <iframe
                src={gameUrl}
                frameBorder="0"
                allowFullScreen
                onLoad={() => setLoading(false)}
                style={{
                    flex: 1,
                    width: '100%',
                    height: '100%',
                    border: 'none',
                    opacity: loading ? 0 : 1,
                    transition: 'opacity 0.3s ease'
                }}
            />
        </div>
    );
};

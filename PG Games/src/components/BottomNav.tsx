import React, { useState } from 'react';

export const BottomNav: React.FC = () => {
    const [activeTab, setActiveTab] = useState('inicio');

    const navItems = [
        { id: 'inicio', icon: '🏠', label: 'Início' },
        { id: 'promocao', icon: '🎁', label: 'Promoção' },
        { id: 'deposito', icon: '💰', label: 'Depósito', isSpecial: true },
        { id: 'saque', icon: '💵', label: 'Saque' },
        { id: 'perfil', icon: '👤', label: 'Perfil' },
    ];

    return (
        <nav className="bottom-nav" style={{
            position: 'fixed',
            bottom: 0,
            left: 0,
            right: 0,
            background: 'rgba(22, 33, 62, 0.98)',
            backdropFilter: 'blur(20px)',
            display: 'flex',
            justifyContent: 'space-around',
            padding: '10px 0',
            borderTop: '1px solid rgba(255,255,255,0.1)',
            boxShadow: '0 -4px 20px rgba(0,0,0,0.3)',
            zIndex: 1000
        }}>
            {navItems.map((item) => (
                <button
                    key={item.id}
                    className={`nav-item ${activeTab === item.id ? 'active' : ''} ${item.isSpecial ? 'deposit-btn' : ''}`}
                    onClick={() => setActiveTab(item.id)}
                    style={{
                        background: item.isSpecial ? 'linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)' : 'none',
                        border: 'none',
                        color: item.isSpecial ? 'white' : (activeTab === item.id ? '#2ecc71' : '#bdc3c7'),
                        cursor: 'pointer',
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                        gap: '4px',
                        padding: item.isSpecial ? '10px 15px' : '5px 15px',
                        transition: 'all 0.3s ease',
                        flex: 1,
                        borderRadius: item.isSpecial ? '12px' : '0',
                        marginTop: item.isSpecial ? '-10px' : '0',
                        boxShadow: item.isSpecial ? '0 4px 15px rgba(46, 204, 113, 0.3)' : 'none'
                    }}
                >
                    <span className="nav-icon" style={{ fontSize: '24px' }}>{item.icon}</span>
                    <span className="nav-label" style={{ fontSize: '11px', fontWeight: 600 }}>{item.label}</span>
                </button>
            ))}
        </nav>
    );
};

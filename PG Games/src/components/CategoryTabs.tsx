import React from 'react';

export const CategoryTabs: React.FC = () => {
    return (
        <div className="category-tabs" style={{
            display: 'flex',
            padding: '15px',
            borderBottom: '1px solid var(--kto-border)',
            overflowX: 'auto',
            gap: '10px'
        }}>
            <div style={{
                padding: '8px 20px',
                borderRadius: '20px',
                fontSize: '14px',
                fontWeight: 600,
                cursor: 'default',
                background: 'var(--kto-red)',
                color: 'white',
                border: 'none',
                whiteSpace: 'nowrap'
            }}>
                🔥 Popular
            </div>
        </div>
    );
};

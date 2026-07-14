// ============================================================
// DIGITAL MUSIC STORE - COLOR CHANGER WITH GRADIENTS
// ============================================================

// ============================================================
// 1. GRADIENT COLOR COMBINATIONS
// ============================================================

const gradients = [
    // Dark & Moody
    'linear-gradient(135deg, #0a0a0a, #1a1a2e)',
    'linear-gradient(135deg, #1a1a2e, #16213e)',
    'linear-gradient(135deg, #16213e, #0f3460)',
    'linear-gradient(135deg, #0f3460, #1b1b2f)',
    'linear-gradient(135deg, #1b1b2f, #2d1b3d)',
    'linear-gradient(135deg, #2d1b3d, #1a2a2a)',
    
    // Warm & Rich
    'linear-gradient(135deg, #1a0a0a, #2a1a1a)',
    'linear-gradient(135deg, #2a1a1a, #3d1b1b)',
    'linear-gradient(135deg, #3d1b1b, #2a1a2a)',
    'linear-gradient(135deg, #2a1a2a, #1a0a2a)',
    'linear-gradient(135deg, #1a0a2a, #0a0a2a)',
    
    // Nature Inspired
    'linear-gradient(135deg, #0a1a0a, #1a2a1a)',
    'linear-gradient(135deg, #1a2a1a, #1a2a2a)',
    'linear-gradient(135deg, #1a2a2a, #0a2a2a)',
    'linear-gradient(135deg, #0a2a2a, #0a1a2a)',
    
    // Purple & Blue
    'linear-gradient(135deg, #1a0a2a, #2a1a3d)',
    'linear-gradient(135deg, #2a1a3d, #0a1a3d)',
    'linear-gradient(135deg, #0a1a3d, #0a0a3d)',
    'linear-gradient(135deg, #0a0a3d, #1a0a3d)',
    
    // Vibrant Dark
    'linear-gradient(135deg, #1a0a0a, #2a1a0a)',
    'linear-gradient(135deg, #2a1a0a, #1a2a0a)',
    'linear-gradient(135deg, #1a2a0a, #0a2a1a)',
    'linear-gradient(135deg, #0a2a1a, #0a1a2a)',
    
    // Deep Reds & Purples
    'linear-gradient(135deg, #2a0a0a, #3d0a0a)',
    'linear-gradient(135deg, #3d0a0a, #2a0a2a)',
    'linear-gradient(135deg, #2a0a2a, #1a0a3d)',
    'linear-gradient(135deg, #1a0a3d, #0a0a3d)',
    
    // Teal & Blue
    'linear-gradient(135deg, #0a1a1a, #0a2a2a)',
    'linear-gradient(135deg, #0a2a2a, #0a2a1a)',
    'linear-gradient(135deg, #0a2a1a, #0a1a1a)',
    
    // Sunset Vibes
    'linear-gradient(135deg, #1a0a0a, #2a1a0a)',
    'linear-gradient(135deg, #2a1a0a, #2a0a0a)',
    'linear-gradient(135deg, #2a0a0a, #1a0a0a)',
];

let gradientIndex = 0;

// ============================================================
// 2. CHANGE BACKGROUND WITH GRADIENT
// ============================================================

function changeBackgroundColor() {
    // Get current gradient
    const currentGradient = gradients[gradientIndex];
    
    // Get all elements to apply gradient
    const body = document.body;
    const appContainer = document.querySelector('.app-container');
    const mainContent = document.querySelector('.main-content-area');
    const sidebar = document.querySelector('.sidebar-left');
    const musicCards = document.querySelectorAll('.music-card');
    const featuredCard = document.querySelector('.featured-card');
    
    // Apply gradient to body
    body.style.background = currentGradient;
    body.style.transition = 'background 1s ease';
    body.style.backgroundAttachment = 'fixed';
    
    // Apply gradient to app container
    if (appContainer) {
        appContainer.style.background = currentGradient;
        appContainer.style.transition = 'background 1s ease';
        appContainer.style.backgroundAttachment = 'fixed';
    }
    
    // Apply gradient to main content
    if (mainContent) {
        mainContent.style.background = currentGradient;
        mainContent.style.transition = 'background 1s ease';
        mainContent.style.backgroundAttachment = 'fixed';
    }
    
    // Apply gradient to sidebar
    if (sidebar) {
        sidebar.style.background = currentGradient;
        sidebar.style.transition = 'background 1s ease';
        sidebar.style.backgroundAttachment = 'fixed';
    }
    
    // Apply gradient to music cards with glass effect
    musicCards.forEach(card => {
        card.style.background = 'rgba(20, 20, 30, 0.4)';
        card.style.backdropFilter = 'blur(10px)';
        card.style.border = '1px solid rgba(255,255,255,0.08)';
        card.style.transition = 'background 1s ease';
    });
    
    // Featured card with special effect
    if (featuredCard) {
        featuredCard.style.background = 'rgba(20, 20, 30, 0.3)';
        featuredCard.style.backdropFilter = 'blur(15px)';
        featuredCard.style.border = '1px solid rgba(255,255,255,0.1)';
    }
    
    // Move to next gradient, loop back to start
    gradientIndex = (gradientIndex + 1) % gradients.length;
    
    // Show notification
   // showGradientNotification(gradientIndex);
}

// ============================================================
// 3. GRADIENT NOTIFICATION
// ============================================================

/*function showGradientNotification(index) {
    // Remove existing notification if any
    const existingNotification = document.querySelector('.color-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Get gradient name from index
    const gradientNames = [
        '🌙 Dark & Moody',
        '🌙 Dark & Moody',
        '🌊 Deep Blue',
        '💜 Purple Dream',
        '🌹 Rich Plum',
        '🌲 Forest Night',
        '🔥 Warm Ember',
        '🔴 Deep Crimson',
        '🌸 Berry Bliss',
        '🌌 Cosmic Purple',
        '🌿 Forest Green',
        '🌊 Ocean Depths',
        '🌿 Sage Shadow',
        '💎 Sapphire',
        '🌙 Midnight Violet',
        '🌀 Indigo Storm',
        '🌊 Deep Azure',
        '🌙 Starlight',
        '🔥 Sunset Glow',
        '🌿 Emerald Night',
        '🌲 Pine Forest',
        '🌊 Teal Abyss',
        '🔥 Ruby Glow',
        '💜 Amethyst',
        '💎 Royal Blue',
        '🌊 Cyan Depths',
        '🌿 Olive Night',
        '🌅 Sunset Ember',
        '🔥 Golden Hour',
        '🌺 Rosewood',
    ];
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = 'color-notification';
    notification.style.cssText = `
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(15px);
        color: #fff;
        padding: 10px 28px;
        border-radius: 30px;
        font-size: 14px;
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease;
        border: 1px solid rgba(255,255,255,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 4px 30px rgba(0,0,0,0.4);
        letter-spacing: 0.5px;
    `;
    
    const name = gradientNames[index % gradientNames.length] || '🎨 New Gradient';
    notification.textContent = `✨ ${name}`;
    document.body.appendChild(notification);
    
    // Auto-hide after 1.8 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 1800);
}*/

// ============================================================
// 4. CLICK EVENT LISTENER
// ============================================================

document.addEventListener('click', function(event) {
    // Ignore clicks on interactive elements
    const tagName = event.target.tagName.toLowerCase();
    const interactiveTags = ['button', 'a', 'input', 'select', 'textarea', 'audio'];
    
    if (!interactiveTags.includes(tagName)) {
        changeBackgroundColor();
    }
});

// ============================================================
// 5. KEYBOARD SHORTCUT: Press 'G' for Gradient Change
// ============================================================

document.addEventListener('keydown', function(event) {
    if ((event.key === 'g' || event.key === 'G') && 
        event.target.tagName !== 'INPUT' && 
        event.target.tagName !== 'TEXTAREA') {
        changeBackgroundColor();
    }
});

// ============================================================
// 6. PLAY BUTTON HOVER EFFECT (Apple Music Style)
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    // Play buttons
    const playButtons = document.querySelectorAll('.play-btn');
    
    playButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.15)';
            this.style.boxShadow = '0 0 30px rgba(240, 165, 0, 0.6)';
            this.style.transition = 'all 0.3s ease';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Music cards hover effect
    const musicCards = document.querySelectorAll('.music-card');
    musicCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-6px)';
            this.style.boxShadow = '0 12px 40px rgba(0,0,0,0.4)';
            this.style.transition = 'all 0.3s ease';
            this.style.borderColor = 'rgba(240, 165, 0, 0.3)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
            this.style.borderColor = 'rgba(255,255,255,0.08)';
        });
    });
});

// ============================================================
// 7. SEARCH BAR FUNCTIONALITY
// ============================================================

function setupSearch() {
    const searchInput = document.querySelector('.search-box input');
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const searchTerm = this.value.toLowerCase();
            const musicCards = document.querySelectorAll('.music-card');
            
            musicCards.forEach(card => {
                const title = card.querySelector('h4')?.textContent.toLowerCase() || '';
                const artist = card.querySelector('p')?.textContent.toLowerCase() || '';
                
                if (title.includes(searchTerm) || artist.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                } else {
                    card.style.display = 'none';
                    card.style.opacity = '0';
                }
            });
        });
    }
}

// ============================================================
// 8. INITIALIZATION
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    setupSearch();
    // Apply first gradient on load
    setTimeout(changeBackgroundColor, 500);
});

// ============================================================
// 9. CONSOLE MESSAGE
// ============================================================

/*console.log('🎨 Digital Music Store - Gradient Backgrounds Active!');
console.log('✨ Click anywhere or press "G" to change gradient!');
console.log('🎵 Enjoy the colors!');*/
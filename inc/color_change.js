const gradients = [
    'linear-gradient(135deg, #0a0a0a, #1a1a2e)',
    'linear-gradient(135deg, #1a1a2e, #16213e)',
    'linear-gradient(135deg, #16213e, #0f3460)',
    'linear-gradient(135deg, #0f3460, #1b1b2f)',
    'linear-gradient(135deg, #1b1b2f, #2d1b3d)',
    'linear-gradient(135deg, #2d1b3d, #1a2a2a)',
    
    'linear-gradient(135deg, #1a0a0a, #2a1a1a)',
    'linear-gradient(135deg, #2a1a1a, #3d1b1b)',
    'linear-gradient(135deg, #3d1b1b, #2a1a2a)',
    'linear-gradient(135deg, #2a1a2a, #1a0a2a)',
    'linear-gradient(135deg, #1a0a2a, #0a0a2a)',
    
    'linear-gradient(135deg, #0a1a0a, #1a2a1a)',
    'linear-gradient(135deg, #1a2a1a, #1a2a2a)',
    'linear-gradient(135deg, #1a2a2a, #0a2a2a)',
    'linear-gradient(135deg, #0a2a2a, #0a1a2a)',
    
    'linear-gradient(135deg, #1a0a2a, #2a1a3d)',
    'linear-gradient(135deg, #2a1a3d, #0a1a3d)',
    'linear-gradient(135deg, #0a1a3d, #0a0a3d)',
    'linear-gradient(135deg, #0a0a3d, #1a0a3d)',
    
    'linear-gradient(135deg, #1a0a0a, #2a1a0a)',
    'linear-gradient(135deg, #2a1a0a, #1a2a0a)',
    'linear-gradient(135deg, #1a2a0a, #0a2a1a)',
    'linear-gradient(135deg, #0a2a1a, #0a1a2a)',
    
    'linear-gradient(135deg, #2a0a0a, #3d0a0a)',
    'linear-gradient(135deg, #3d0a0a, #2a0a2a)',
    'linear-gradient(135deg, #2a0a2a, #1a0a3d)',
    'linear-gradient(135deg, #1a0a3d, #0a0a3d)',
    
    'linear-gradient(135deg, #0a1a1a, #0a2a2a)',
    'linear-gradient(135deg, #0a2a2a, #0a2a1a)',
    'linear-gradient(135deg, #0a2a1a, #0a1a1a)',
    
    'linear-gradient(135deg, #1a0a0a, #2a1a0a)',
    'linear-gradient(135deg, #2a1a0a, #2a0a0a)',
    'linear-gradient(135deg, #2a0a0a, #1a0a0a)',
];

let gradientIndex = 0;

function changeBackgroundColor() {
    const currentGradient = gradients[gradientIndex];
    
    const body = document.body;
    const appContainer = document.querySelector('.app-container');
    const mainContent = document.querySelector('.main-content-area');
    const sidebar = document.querySelector('.sidebar-left');
    const musicCards = document.querySelectorAll('.music-card');
    const featuredCard = document.querySelector('.featured-card');
    
    body.style.background = currentGradient;
    body.style.transition = 'background 1s ease';
    body.style.backgroundAttachment = 'fixed';
    
    if (appContainer) {
        appContainer.style.background = currentGradient;
        appContainer.style.transition = 'background 1s ease';
        appContainer.style.backgroundAttachment = 'fixed';
    }
    
    if (mainContent) {
        mainContent.style.background = currentGradient;
        mainContent.style.transition = 'background 1s ease';
        mainContent.style.backgroundAttachment = 'fixed';
    }
    
    if (sidebar) {
        sidebar.style.background = currentGradient;
        sidebar.style.transition = 'background 1s ease';
        sidebar.style.backgroundAttachment = 'fixed';
    }
    
    musicCards.forEach(card => {
        card.style.background = 'rgba(20, 20, 30, 0.4)';
        card.style.backdropFilter = 'blur(10px)';
        card.style.border = '1px solid rgba(255,255,255,0.08)';
        card.style.transition = 'background 1s ease';
    });
    
    if (featuredCard) {
        featuredCard.style.background = 'rgba(20, 20, 30, 0.3)';
        featuredCard.style.backdropFilter = 'blur(15px)';
        featuredCard.style.border = '1px solid rgba(255,255,255,0.1)';
    }
    
    gradientIndex = (gradientIndex + 1) % gradients.length;
    
}


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
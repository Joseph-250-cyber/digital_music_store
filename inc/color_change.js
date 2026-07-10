const colors = [
    'Black',
    'Navy',
    'Deep Blue',
    'Royal Blue',
    'Dark Purple',
    'Plum',
    'Dark Teal',
    'Dark Red',
    'Almost Black',
    'Midnight Blue',
    'Forest Green',
    'Dark Magenta',
    'Dark Green',
    'Dark Olive',
    'Dark Cyan',
    'Dark Maroon',
    'Dark Indigo',
    'Very Dark Blue',
    'Very Dark Purple',
    'Very Dark Teal'
];

let colorIndex = 0;

function changeBackgroundColor() {
    // Get elements
    const body = document.body;
    const appContainer = document.querySelector('.app-container');
    const mainContent = document.querySelector('.main-content-area');
    const sidebar = document.querySelector('.sidebar-left');
    
    // Change body background
    body.style.backgroundColor = colors[colorIndex];
    body.style.transition = 'background-color 0.8s ease';
    
    // Change app container background
    if (appContainer) {
        appContainer.style.backgroundColor = colors[colorIndex];
        appContainer.style.transition = 'background-color 0.8s ease';
    }
    
    // Change main content background
    if (mainContent) {
        mainContent.style.backgroundColor = colors[colorIndex];
        mainContent.style.transition = 'background-color 0.8s ease';
    }
    
    // Optional: Change sidebar background slightly different
    if (sidebar) {
        sidebar.style.backgroundColor = colors[colorIndex];
        sidebar.style.transition = 'background-color 0.8s ease';
    }
    
    // Move to next color, loop back to start
    colorIndex = (colorIndex + 1) % colors.length;
    
}



// ============================================================
// 2. ADD CLICK EVENT LISTENER
// ============================================================

// Click anywhere to change color
document.addEventListener('click', function(event) {
    // Ignore clicks on interactive elements (buttons, links, inputs)
    const tagName = event.target.tagName.toLowerCase();
    const interactiveTags = ['button', 'a', 'input', 'select', 'textarea'];
    
    if (!interactiveTags.includes(tagName)) {
        changeBackgroundColor();
    }
});


// ============================================================
// 3. KEYBOARD SHORTCUT: Press 'C' to change color
// ============================================================

document.addEventListener('keydown', function(event) {
    // If 'c' key is pressed (or 'C')
    if (event.key === 'c' || event.key === 'C') {
        // Don't trigger if typing in an input
        if (event.target.tagName !== 'INPUT' && event.target.tagName !== 'TEXTAREA') {
            changeBackgroundColor();
        }
    }
});


// ============================================================
// 4. PLAY BUTTON HOVER EFFECT (Apple Music Style)
// ============================================================

// Add a subtle glow effect to play buttons on hover
document.addEventListener('DOMContentLoaded', function() {
    const playButtons = document.querySelectorAll('.play-btn');
    
    playButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 0 20px rgba(240, 165, 0, 0.4)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
});


// ============================================================
// 7. SEARCH BAR FUNCTIONALITY (Optional)
// ============================================================

// Add search functionality if needed
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
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
}

// Initialize search when page loads
document.addEventListener('DOMContentLoaded', function() {
    setupSearch();
});
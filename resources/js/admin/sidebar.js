/**
 * Admin Sidebar Controller
 * Handles sidebar collapse/expand functionality with state persistence
 */

class SidebarController {
    constructor() {
        this.sidebar = null;
        this.toggleButton = null;
        this.state = {
            collapsed: false,
            storageKey: 'parkitSidebarState',
            isAnimating: false
        };
        
        this.selectors = {
            sidebar: '#app-sidebar',
            toggleBtn: '#toggle-sidebar-btn',
            navLabels: '[data-nav="label"]',
            profileInfo: '[data-profile="info"]',
            profileLogout: '[data-profile="logout"]',
            profileCard: '[data-profile="card"]',
            profileContainer: '[data-profile="container"]',
            header: '[data-header="brand-toggle"]',
            brandFull: '[data-brand="full"]',
            hamburgerIcon: '[data-icon="hamburger"]',
            logoutForm: '#logout-form'
        };
        
        this.dimensions = {
            expanded: '256px',
            collapsed: '80px'
        };
        
        this.init();
    }

    /**
     * Initialize the sidebar controller
     */
    init() {
        this.cacheElements();
        
        if (!this.sidebar || !this.toggleButton) {
            console.warn('Sidebar elements not found');
            return;
        }
        
        this.loadState();
        this.applyInitialState();
        this.attachEventListeners();
    }

    /**
     * Cache DOM elements for better performance
     */
    cacheElements() {
        this.sidebar = document.querySelector(this.selectors.sidebar);
        this.toggleButton = document.querySelector(this.selectors.toggleBtn);
    }

    /**
     * Load saved state from localStorage
     */
    loadState() {
        try {
            const savedState = localStorage.getItem(this.state.storageKey);
            if (savedState !== null) {
                this.state.collapsed = savedState === 'true';
            }
        } catch (error) {
            console.error('Failed to load sidebar state:', error);
        }
    }

    /**
     * Save current state to localStorage
     */
    saveState() {
        try {
            localStorage.setItem(this.state.storageKey, this.state.collapsed.toString());
        } catch (error) {
            console.error('Failed to save sidebar state:', error);
        }
    }

    /**
     * Apply initial state without animation (to avoid flicker on page load)
     */
    applyInitialState() {
        const sidebar = this.sidebar;
        // Terapkan state tanpa animasi via CSS gating (data-ready="false" + class pada html)
        if (this.state.collapsed) {
            sidebar.style.width = this.dimensions.collapsed;
            sidebar.setAttribute('data-state', 'collapsed');
            document.documentElement.classList.add('sidebar-collapsed');
        } else {
            sidebar.style.width = this.dimensions.expanded;
            sidebar.setAttribute('data-state', 'expanded');
            document.documentElement.classList.remove('sidebar-collapsed');
        }
        // Tandai siap: aktifkan kembali transition via CSS (tanpa setTimeout)
        sidebar.dataset.ready = 'true';
    }


    /**
     * Attach event listeners
     */
    attachEventListeners() {
        this.toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.toggle();
        });

        // Logout confirm ditangani sekali di app.js (menghindari double dialog)
    }

    /**
     * Toggle sidebar between collapsed and expanded states
     */
    toggle() {
        if (this.state.isAnimating) return;
        
        this.state.collapsed = !this.state.collapsed;
        this.applyState();
        this.saveState();
    }

    /**
     * Apply the current state to the UI
     */
    applyState() {
        if (this.state.collapsed) {
            this.collapse();
        } else {
            this.expand();
        }
    }

    /**
     * Collapse the sidebar
     */
    collapse() {
        this.state.isAnimating = true;
        
        // Hide navigation labels immediately for smooth collapse
        this.hideElements(this.selectors.navLabels);
        
        // Hide profile information (hanya avatar yang tampil)
        this.hideElements(this.selectors.profileInfo);
        this.hideElements(this.selectors.profileLogout);

        // CSS mengatur layout brand/header/profile saat collapse via html.sidebar-collapsed
        document.documentElement.classList.add('sidebar-collapsed');
        
        // Update sidebar width and state attribute
        this.sidebar.style.width = this.dimensions.collapsed;
        this.sidebar.setAttribute('data-state', 'collapsed');
        
        // Finish animation
        setTimeout(() => {
            this.state.isAnimating = false;
        }, 300);
    }

    /**
     * Expand the sidebar
     */
    expand() {
        this.state.isAnimating = true;
        
        // Update sidebar width and state attribute
        this.sidebar.style.width = this.dimensions.expanded;
        this.sidebar.setAttribute('data-state', 'expanded');

        // CSS mengatur layout brand/header/profile saat expanded via html class
        document.documentElement.classList.remove('sidebar-collapsed');
        
        // Show navigation labels after width transition starts
        setTimeout(() => {
            this.showElements(this.selectors.navLabels);
            this.showElements(this.selectors.profileInfo);
            this.showElements(this.selectors.profileLogout);
        }, 50);
        
        // Finish animation
        setTimeout(() => {
            this.state.isAnimating = false;
        }, 300);
    }

    /**
     * Hide elements matching the selector
     */
    hideElements(selector) {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            element.style.opacity = '0';
            element.style.visibility = 'hidden';
            element.classList.add('hidden');
        });
    }

    /**
     * Show elements matching the selector
     */
    showElements(selector) {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            element.style.opacity = '1';
            element.style.visibility = 'visible';
            element.classList.remove('hidden');
        });
    }

    /**
     * Public method to programmatically collapse sidebar
     */
    forceCollapse() {
        if (!this.state.collapsed) {
            this.toggle();
        }
    }

    /**
     * Public method to programmatically expand sidebar
     */
    forceExpand() {
        if (this.state.collapsed) {
            this.toggle();
        }
    }

    /**
     * Get current sidebar state
     */
    getState() {
        return {
            collapsed: this.state.collapsed,
            width: this.sidebar.style.width
        };
    }
}

// Initialize sidebar when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.sidebarController = new SidebarController();
    });
} else {
    // DOM is already loaded
    window.sidebarController = new SidebarController();
}

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SidebarController;
}

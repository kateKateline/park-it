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
            brandFull: '[data-brand="full"]',
            brandMini: '[data-brand="mini"]',
            collapseIcon: '[data-icon="collapse"]',
            expandIcon: '[data-icon="expand"]'
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
        this.attachEventListeners();
        this.applyState();
        this.handleResponsive();
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
     * Attach event listeners
     */
    attachEventListeners() {
        this.toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.toggle();
        });
        
        window.addEventListener('resize', () => this.handleResponsive());
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
        
        // Hide profile information
        this.hideElements(this.selectors.profileInfo);
        this.hideElements(this.selectors.profileLogout);
        
        // Switch brand display
        this.hideElements(this.selectors.brandFull);
        this.showElements(this.selectors.brandMini);
        
        // Switch toggle icons
        this.hideElements(this.selectors.collapseIcon);
        this.showElements(this.selectors.expandIcon);
        
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
        
        // Switch brand display
        this.showElements(this.selectors.brandFull);
        this.hideElements(this.selectors.brandMini);
        
        // Switch toggle icons
        this.showElements(this.selectors.collapseIcon);
        this.hideElements(this.selectors.expandIcon);
        
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
     * Handle responsive behavior
     */
    handleResponsive() {
        const isDesktop = window.matchMedia('(min-width: 768px)').matches;
        
        if (isDesktop) {
            this.toggleButton.classList.remove('hidden');
        } else {
            this.toggleButton.classList.add('hidden');
            // Reset to expanded state on mobile
            if (this.state.collapsed) {
                this.state.collapsed = false;
                this.applyState();
            }
        }
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
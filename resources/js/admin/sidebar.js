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
        const originalSidebarTransition = sidebar.style.transition;

        // Matikan transition sementara di sidebar dan elemen-elemen terkait
        sidebar.style.transition = 'none';
        const affectedSelectors = [
            this.selectors.navLabels,
            this.selectors.profileInfo,
            this.selectors.profileLogout,
            this.selectors.profileCard,
            this.selectors.profileContainer,
            this.selectors.brandFull
        ];

        const originalTransitions = new Map();
        affectedSelectors.forEach(selector => {
            if (!selector) return;
            document.querySelectorAll(selector).forEach(el => {
                originalTransitions.set(el, el.style.transition);
                el.style.transition = 'none';
            });
        });

        if (this.state.collapsed) {
            // Lebar dan state awal collapse
            sidebar.style.width = this.dimensions.collapsed;
            sidebar.setAttribute('data-state', 'collapsed');

            this.hideElements(this.selectors.navLabels);
            this.hideElements(this.selectors.profileInfo);
            this.hideElements(this.selectors.profileLogout);
            this.hideElements(this.selectors.brandFull);
        } else {
            // Lebar dan state awal expanded
            sidebar.style.width = this.dimensions.expanded;
            sidebar.setAttribute('data-state', 'expanded');

            this.showElements(this.selectors.navLabels);
            this.showElements(this.selectors.profileInfo);
            this.showElements(this.selectors.profileLogout);
            this.showElements(this.selectors.brandFull);
        }

        // Sidebar sudah siap ditampilkan tanpa glitch
        sidebar.classList.remove('opacity-0');
        sidebar.dataset.ready = 'true';

        // Paksa reflow lalu kembalikan transition
        // eslint-disable-next-line no-unused-expressions
        sidebar.offsetHeight;
        sidebar.style.transition = originalSidebarTransition;

        // Kembalikan transition elemen-elemen lain
        originalTransitions.forEach((value, el) => {
            el.style.transition = value;
        });
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

        // Logout confirmation popup
        const logoutForm = document.querySelector(this.selectors.logoutForm);
        if (logoutForm) {
            logoutForm.addEventListener('submit', (e) => {
                const confirmed = window.confirm('Apakah Anda yakin ingin logout?');
                if (!confirmed) {
                    e.preventDefault();
                }
            });
        }
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

        // Pusatkan avatar saat collapse (lebih compact)
        document.querySelectorAll(this.selectors.profileCard).forEach(el => {
            el.classList.add('flex', 'flex-col', 'items-center', 'justify-center', 'p-2');
        });
        document.querySelectorAll(this.selectors.profileContainer).forEach(el => {
            el.classList.add('flex', 'flex-col', 'items-center', 'justify-center', 'gap-1');
        });

        // Sembunyikan brand saat collapse
        this.hideElements(this.selectors.brandFull);

        // Pusatkan header (hanya hamburger) saat collapse
        document.querySelectorAll(this.selectors.header).forEach(el => {
            el.classList.remove('justify-between');
            el.classList.add('justify-center');
        });
        
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

        // Kembalikan layout profile normal (row)
        document.querySelectorAll(this.selectors.profileCard).forEach(el => {
            el.classList.remove('flex', 'flex-col', 'items-center', 'justify-center');
        });
        document.querySelectorAll(this.selectors.profileContainer).forEach(el => {
            el.classList.remove('flex', 'flex-col', 'items-center', 'justify-center', 'gap-2');
            el.classList.add('flex', 'items-center', 'gap-3');
        });

        // Tampilkan kembali brand label
        this.showElements(this.selectors.brandFull);

        // Kembalikan header ke posisi brand kiri, hamburger kanan
        document.querySelectorAll(this.selectors.header).forEach(el => {
            el.classList.remove('justify-center');
            el.classList.add('justify-between');
        });
        
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
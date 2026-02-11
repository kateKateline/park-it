/**
 * Petugas Sidebar Controller
 * Same format as admin sidebar - handles collapse/expand with state persistence
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

    init() {
        this.cacheElements();

        if (!this.sidebar || !this.toggleButton) {
            return;
        }

        this.loadState();
        this.applyInitialState();
        this.attachEventListeners();
    }

    cacheElements() {
        this.sidebar = document.querySelector(this.selectors.sidebar);
        this.toggleButton = document.querySelector(this.selectors.toggleBtn);
    }

    loadState() {
        try {
            const savedState = localStorage.getItem(this.state.storageKey);
            if (savedState !== null) {
                this.state.collapsed = savedState === 'true';
            }
        } catch (e) {}
    }

    saveState() {
        try {
            localStorage.setItem(this.state.storageKey, this.state.collapsed.toString());
        } catch (e) {}
    }

    applyInitialState() {
        const sidebar = this.sidebar;
        if (this.state.collapsed) {
            sidebar.style.width = this.dimensions.collapsed;
            sidebar.setAttribute('data-state', 'collapsed');
            document.documentElement.classList.add('sidebar-collapsed');
        } else {
            sidebar.style.width = this.dimensions.expanded;
            sidebar.setAttribute('data-state', 'expanded');
            document.documentElement.classList.remove('sidebar-collapsed');
        }
        sidebar.dataset.ready = 'true';
    }

    attachEventListeners() {
        this.toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.toggle();
        });

        // Logout confirm ditangani sekali di app.js (menghindari double dialog)
    }

    toggle() {
        if (this.state.isAnimating) return;
        this.state.collapsed = !this.state.collapsed;
        this.applyState();
        this.saveState();
    }

    applyState() {
        this.state.collapsed ? this.collapse() : this.expand();
    }

    collapse() {
        this.state.isAnimating = true;
        this.hideElements(this.selectors.navLabels);
        this.hideElements(this.selectors.profileInfo);
        this.hideElements(this.selectors.profileLogout);
        document.documentElement.classList.add('sidebar-collapsed');
        this.sidebar.style.width = this.dimensions.collapsed;
        this.sidebar.setAttribute('data-state', 'collapsed');
        setTimeout(() => { this.state.isAnimating = false; }, 300);
    }

    expand() {
        this.state.isAnimating = true;
        this.sidebar.style.width = this.dimensions.expanded;
        this.sidebar.setAttribute('data-state', 'expanded');
        document.documentElement.classList.remove('sidebar-collapsed');
        setTimeout(() => {
            this.showElements(this.selectors.navLabels);
            this.showElements(this.selectors.profileInfo);
            this.showElements(this.selectors.profileLogout);
        }, 50);
        setTimeout(() => { this.state.isAnimating = false; }, 300);
    }

    hideElements(selector) {
        document.querySelectorAll(selector).forEach(el => {
            el.style.opacity = '0';
            el.style.visibility = 'hidden';
            el.classList.add('hidden');
        });
    }

    showElements(selector) {
        document.querySelectorAll(selector).forEach(el => {
            el.style.opacity = '1';
            el.style.visibility = 'visible';
            el.classList.remove('hidden');
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.sidebarController = new SidebarController();
    });
} else {
    window.sidebarController = new SidebarController();
}

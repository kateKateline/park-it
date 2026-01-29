/**
 * Sidebar Toggle Logic
 * Handles collapse/expand of sidebar with localStorage persistence
 */

document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    
    if (!sidebar || !sidebarToggle) return;

    // Initialize collapsed state from localStorage
    let isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

    /**
     * Toggle sidebar collapse state
     */
    function toggleSidebar() {
        isCollapsed = !isCollapsed;
        updateSidebarUI();
        localStorage.setItem('sidebar-collapsed', isCollapsed);
    }

    /**
     * Update sidebar UI based on collapsed state
     */
    function updateSidebarUI() {
        if (isCollapsed) {
            // Collapse sidebar
            sidebar.style.width = '80px';
            sidebar.classList.add('sidebar-collapsed');
            
            document.querySelectorAll('.nav-label, .profile-full').forEach(el => {
                el.classList.add('hidden');
            });
            
            document.querySelectorAll('.logo-full').forEach(el => {
                el.classList.add('hidden');
            });
            
            document.querySelectorAll('.logo-icon').forEach(el => {
                el.classList.remove('hidden');
            });
            
            const icon = sidebarToggle.querySelector('i');
            icon?.classList.remove('fa-chevron-left');
            icon?.classList.add('fa-chevron-right');
        } else {
            // Expand sidebar
            sidebar.style.width = '256px';
            sidebar.classList.remove('sidebar-collapsed');
            
            document.querySelectorAll('.nav-label, .profile-full').forEach(el => {
                el.classList.remove('hidden');
            });
            
            document.querySelectorAll('.logo-full').forEach(el => {
                el.classList.remove('hidden');
            });
            
            document.querySelectorAll('.logo-icon').forEach(el => {
                el.classList.add('hidden');
            });
            
            const icon = sidebarToggle.querySelector('i');
            icon?.classList.add('fa-chevron-left');
            icon?.classList.remove('fa-chevron-right');
        }
    }

    /**
     * Initialize sidebar state on page load
     */
    function initializeSidebar() {
        // Always show toggle on desktop, hide on mobile
        if (window.innerWidth >= 768) {
            sidebarToggle.classList.remove('hidden');
        } else {
            sidebarToggle.classList.add('hidden');
        }

        // Apply collapsed state if needed
        if (isCollapsed) {
            updateSidebarUI();
        }
    }

    /**
     * Handle window resize
     */
    function handleResize() {
        if (window.innerWidth >= 768) {
            sidebarToggle.classList.remove('hidden');
        } else {
            sidebarToggle.classList.add('hidden');
        }
    }

    // Event listeners
    sidebarToggle.addEventListener('click', toggleSidebar);
    window.addEventListener('resize', handleResize);

    // Initialize on page load
    initializeSidebar();
});

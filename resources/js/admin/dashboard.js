const NAV_ACTIVE_CLASSES = ['bg-slate-900', 'text-white', 'hover:bg-slate-800'];
const NAV_INACTIVE_CLASSES = ['text-slate-700', 'hover:bg-slate-100'];

function setActiveTab(root, tabId) {
    const triggers = Array.from(root.querySelectorAll('[data-admin-tab]'));
    const panels = Array.from(root.querySelectorAll('[data-admin-panel]'));

    const hasPanel = panels.some((p) => p.getAttribute('data-admin-panel') === tabId);
    const nextId = hasPanel ? tabId : 'overview';

    triggers.forEach((btn) => {
        const isActive = btn.getAttribute('data-admin-tab') === nextId;

        btn.classList.remove(...NAV_ACTIVE_CLASSES);
        btn.classList.remove(...NAV_INACTIVE_CLASSES);

        if (isActive) btn.classList.add(...NAV_ACTIVE_CLASSES);
        else btn.classList.add(...NAV_INACTIVE_CLASSES);

        btn.setAttribute('aria-selected', String(isActive));
    });

    panels.forEach((panel) => {
        const isActive = panel.getAttribute('data-admin-panel') === nextId;
        panel.classList.toggle('hidden', !isActive);
    });

    return nextId;
}

function getTabFromHash() {
    const raw = window.location.hash || '';
    const tab = raw.replace(/^#/, '').trim();
    return tab || 'overview';
}

function initAdminDashboardTabs() {
    const root = document.querySelector('[data-admin-dashboard]');
    if (!root) return;

    // Initial state (supports deep-link via hash).
    setActiveTab(root, getTabFromHash());

    root.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-admin-tab]');
        if (!btn || !root.contains(btn)) return;

        const tabId = btn.getAttribute('data-admin-tab') || 'overview';
        const active = setActiveTab(root, tabId);

        if (active) {
            const nextHash = `#${active}`;
            if (window.location.hash !== nextHash) {
                window.history.replaceState(null, '', nextHash);
            }
        }
    });

    window.addEventListener('hashchange', () => {
        setActiveTab(root, getTabFromHash());
    });
}

initAdminDashboardTabs();


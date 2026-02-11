import './bootstrap';
import './admin/dashboard';
import './admin/sidebar';
import './petugas/sidebar';

// logout handler
(function setupLogoutConfirm() {
    function init() {
        const form = document.getElementById('logout-form');
        if (!form || form.dataset.logoutConfirmDone) return;
        form.dataset.logoutConfirmDone = '1';
        form.addEventListener('submit', function (e) {
            if (!window.confirm('Apakah Anda yakin ingin logout?')) {
                e.preventDefault();
            }
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
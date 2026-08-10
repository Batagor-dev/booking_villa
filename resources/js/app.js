import './components/price';

window.togglePassword = function (inputId, button) {
    const input = document.getElementById(inputId);
    if (!input) return;

    const openEye =
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    const closedEye =
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.75 18.75 0 0 1 5.06-6.06"></path><path d="M1 1l22 22"></path><path d="M9.88 9.88a3 3 0 0 0 4.24 4.24"></path><path d="M14.12 14.12a3 3 0 0 1-4.24-4.24"></path></svg>';

    if (input.type === "password") {
        input.type = "text";
        button.innerHTML = closedEye;
    } else {
        input.type = "password";
        button.innerHTML = openEye;
    }
};

// ============================================================
// AbortController to prevent duplicate listeners on Vite HMR
// ============================================================
if (window.__appAbortController) {
    window.__appAbortController.abort();
}
window.__appAbortController = new AbortController();
const signal = window.__appAbortController.signal;

// ============================================================
// Sidebar toggle initialization (idempotent, HMR-safe)
// ============================================================
function initSidebarToggles() {
    document.querySelectorAll("[data-sidebar-toggle]").forEach((button) => {
        // Skip if already initialized (prevent double-binding)
        if (button._sidebarInitialized) return;
        button._sidebarInitialized = true;

        const targetId = button.dataset.target;
        if (!targetId) return;

        const target = document.getElementById(targetId);
        if (!target) return;

        const setInitialHeight = () => {
            if (button.getAttribute("aria-expanded") === "true") {
                target.style.maxHeight = "none";
            } else {
                target.style.maxHeight = "0px";
            }
        };

        setInitialHeight();

        const handleTransitionEnd = () => {
            if (button.getAttribute("aria-expanded") === "true") {
                target.style.maxHeight = "none";
            }
        };

        button.addEventListener("click", (e) => {
            // Prevent click from bubbling issues
            e.stopPropagation();
            
            const isExpanded = button.getAttribute("aria-expanded") === "true";
            target.removeEventListener("transitionend", handleTransitionEnd);

            if (isExpanded) {
                target.style.maxHeight = `${target.scrollHeight}px`;
                // Force repaint
                target.offsetHeight;

                button.setAttribute("aria-expanded", "false");
                requestAnimationFrame(() => {
                    target.style.maxHeight = "0px";
                });
            } else {
                button.setAttribute("aria-expanded", "true");
                target.style.maxHeight = `${target.scrollHeight}px`;
                target.addEventListener("transitionend", handleTransitionEnd, { once: true });
            }
        });

        window.addEventListener("resize", setInitialHeight, { signal });
    });
}

// ============================================================
// Select2 initialization
// ============================================================
function initSelect2() {
    if (typeof jQuery !== 'undefined' && $.fn.select2) {
        $('.select2').each(function() {
            // Skip if already initialized
            if ($(this).data('select2')) return;
            $(this).select2({
                width: '100%',
                placeholder: $(this).data('placeholder') || 'Pilih opsi...',
                allowClear: $(this).data('allow-clear') || false
            });
        });
    }
}

// ============================================================
// Run initialization - works both on first load & HMR
// ============================================================
if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", () => {
        initSidebarToggles();
        initSelect2();
    }, { once: true });
} else {
    // DOM already ready (HMR reload or deferred script)
    initSidebarToggles();
    initSelect2();
}

// --- Custom Page Loader & Progress Bar (NProgress style) ---
// Reuse existing ProgressBar if already defined (HMR-safe)
if (!window.ProgressBar) {
    window.ProgressBar = {
        status: null,
        timeout: null,
        elements: {
            container: null,
            bar: null,
            spinner: null
        },

        create() {
            // Reuse existing DOM element if present
            const existing = document.getElementById('nprogress');
            if (existing) {
                this.elements.container = existing;
                this.elements.bar = existing.querySelector('.bar');
                if (this.elements.bar) return;
            }

            if (this.elements.container) return;

            const container = document.createElement('div');
            container.id = 'nprogress';
            
            const bar = document.createElement('div');
            bar.className = 'bar';
            bar.setAttribute('role', 'bar');

            container.appendChild(bar);
            document.body.appendChild(container);

            this.elements.container = container;
            this.elements.bar = bar;
        },

        set(n) {
            this.create();
            n = Math.max(0, Math.min(1, n));
            this.status = n;

            if (!this.elements.bar) return;

            // Force repaint
            this.elements.bar.offsetWidth;

            this.elements.bar.style.width = (n * 100) + '%';
            this.elements.bar.style.opacity = '1';
        },

        start() {
            if (this.status !== null) {
                if (this.status >= 1) this.set(0);
            } else {
                this.set(0);
            }

            const work = () => {
                this.timeout = setTimeout(() => {
                    if (this.status === null || this.status >= 0.99) return;
                    
                    let amount = 0;
                    if (this.status >= 0 && this.status < 0.2) amount = 0.1;
                    else if (this.status >= 0.2 && this.status < 0.5) amount = 0.04;
                    else if (this.status >= 0.5 && this.status < 0.8) amount = 0.02;
                    else if (this.status >= 0.8 && this.status < 0.99) amount = 0.005;

                    this.set(this.status + amount);
                    work();
                }, 200);
            };

            work();
        },

        done() {
            if (this.status === null) return;

            clearTimeout(this.timeout);
            this.set(1);

            setTimeout(() => {
                if (this.elements.bar) {
                    this.elements.bar.style.opacity = '0';
                }
                setTimeout(() => {
                    if (this.elements.bar) {
                        this.elements.bar.style.width = '0%';
                    }
                    this.status = null;
                }, 200);
            }, 300);
        }
    };
}

const ProgressBar = window.ProgressBar;

// Helper to check if we are in the admin panel
const isAdminPanel = () => {
    return !!document.querySelector('[data-admin-panel="true"]') || !!document.getElementById('admin-sidebar');
};

// ============================================================
// Progress bar link click handler (with AbortController to prevent duplicates)
// ============================================================
document.addEventListener('click', (event) => {
    if (!isAdminPanel()) return;

    const link = event.target.closest('a');
    if (!link) return;

    const href = link.getAttribute('href');
    const target = link.getAttribute('target');

    if (!href) return;
    if (href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
    if (target && target === '_blank') return;
    if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return; 

    // Same origin check
    try {
        const url = new URL(href, window.location.href);
        if (url.origin !== window.location.origin) return;
    } catch (e) {
        return;
    }

    ProgressBar.start();
}, { signal });

// Run complete animation on load (wait for DOM to be ready)
function initProgressBar() {
    if (isAdminPanel()) {
        ProgressBar.start();
    }
    setTimeout(() => {
        ProgressBar.done();
    }, 150);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProgressBar, { once: true });
} else {
    initProgressBar();
}

window.addEventListener('pageshow', (event) => {
    if (event.persisted) {
        ProgressBar.done();
    }
}, { signal });

// --- Cegah Double Submit Form Secara Global + Loading Spinner ---
document.addEventListener("submit", (event) => {
    const form = event.target;
    
    // Abaikan jika form memiliki class 'no-prevent-double-submit'
    if (form.classList.contains('no-prevent-double-submit')) {
        return;
    }

    // Abaikan jika form HTML5 validation gagal (misal field required belum diisi)
    if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
        return;
    }
    
    // SVG spinner icon
    const spinnerSvg = `<svg class="btn-submit-spinner w-4 h-4 animate-spin text-current shrink-0 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>`;

    // Cari tombol submit dalam form ini
    const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
    
    // Jalankan disable secara asinkron agar tidak membatalkan submit bawaan browser pada klik pertama
    setTimeout(() => {
        submitButtons.forEach((button) => {
            // Skip jika sudah di-disable (mencegah double processing)
            if (button.disabled) return;

            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-not-allowed');
            
            // Untuk input[type="submit"], kita tidak bisa inject HTML, cukup disable saja
            if (button.tagName === 'INPUT') return;

            // Preserve inner span class (font size, font weight, uppercase, tracking, font family)
            const innerSpan = button.querySelector('span');
            const spanClass = innerSpan ? innerSpan.className : '';
            const loadingText = button.getAttribute('data-loading-text') 
                || (innerSpan ? innerSpan.textContent.trim() : button.textContent.trim());

            // Simpan konten asli agar bisa di-restore jika perlu
            button._originalHTML = button.innerHTML;

            button.innerHTML = `${spinnerSvg}<span class="${spanClass}">${loadingText}...</span>`;
        });
    }, 0);
}, { signal });

// ============================================================
// Vite HMR support - clean up and re-init on hot reload
// ============================================================
if (import.meta.hot) {
    import.meta.hot.accept(() => {
        // Module will re-execute, AbortController at top will clean up old listeners
    });
}


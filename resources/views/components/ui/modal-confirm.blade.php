<div 
    id="confirm-modal" 
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300"
>
    <!-- Backdrop -->
    <div 
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"
        onclick="closeConfirmModal()"
    ></div>

    <!-- Modal Content -->
    <div 
        class="relative w-full max-w-md transform rounded-3xl bg-white p-6 shadow-2xl transition-all duration-300 translate-y-4"
    >
        {{-- Close button --}}
        <button 
            type="button"
            onclick="closeConfirmModal()"
            class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors"
        >
            <i class="ri-close-line text-xl"></i>
        </button>

        {{-- Icon & Header --}}
        <div class="flex items-start gap-4">
            <div id="confirm-modal-icon-bg" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-500 border border-rose-100">
                <i id="confirm-modal-icon" class="ri-alert-line text-2xl"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-lg font-satoshi-bold text-slate-900" id="confirm-modal-title">
                    Apakah Anda yakin?
                </h3>
                <p class="text-sm font-satoshi-medium text-slate-500 leading-relaxed" id="confirm-modal-message">
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex items-center justify-end gap-3 border-t border-slate-100 pt-4">
            <x-ui.button 
                type="button" 
                style="secondary" 
                size="sm" 
                onclick="closeConfirmModal()"
            >
                Batal
            </x-ui.button>
            <button 
                type="button" 
                id="confirm-modal-btn"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-satoshi-bold text-white bg-rose-600 hover:bg-rose-700 active:bg-rose-800 rounded-xl transition-all shadow-sm cursor-pointer"
            >
                Ya, Konfirmasi
            </button>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        let confirmModalCallback = null;
        let confirmFormToSubmit = null;

        document.addEventListener("DOMContentLoaded", () => {
            // Gunakan event delegation agar tombol delete di dalam Yajra DataTable tetap berfungsi
            document.addEventListener("click", (event) => {
                const btn = event.target.closest(".delete-btn");
                if (btn) {
                    event.preventDefault();
                    const form = btn.closest("form");
                    openConfirmModal({
                        title: "Apakah Anda yakin?",
                        message: "Data ini akan dihapus dari sistem.",
                        variant: "danger",
                        confirmText: "Ya, Hapus!",
                        icon: "ri-alert-line text-2xl",
                        form: form
                    });
                }
            });

            // Bind click event untuk konfirmasi
            const confirmBtn = document.getElementById("confirm-modal-btn");
            if (confirmBtn) {
                confirmBtn.addEventListener("click", () => {
                    const callback = confirmModalCallback;
                    const form = confirmFormToSubmit;
                    closeConfirmModal();

                    if (typeof callback === "function") {
                        callback();
                    } else if (form) {
                        form.submit();
                    }
                });
            }
        });

        function openConfirmModal(options = {}) {
            const modal = document.getElementById("confirm-modal");
            if (!modal) return;

            const modalBox = modal.querySelector(".relative");
            const titleEl = document.getElementById("confirm-modal-title");
            const msgEl = document.getElementById("confirm-modal-message");
            const btnEl = document.getElementById("confirm-modal-btn");
            const iconBg = document.getElementById("confirm-modal-icon-bg");
            const iconEl = document.getElementById("confirm-modal-icon");

            const title = options.title || "Apakah Anda yakin?";
            const message = options.message || "Tindakan ini tidak dapat dibatalkan.";
            const confirmText = options.confirmText || "Ya, Konfirmasi";
            const variant = options.variant || "danger";
            
            if (titleEl) titleEl.textContent = title;
            if (msgEl) msgEl.textContent = message;
            if (btnEl) btnEl.textContent = confirmText;

            confirmModalCallback = typeof options.onConfirm === "function" ? options.onConfirm : null;
            confirmFormToSubmit = options.form || null;

            const variantMap = {
                success: {
                    bg: "flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-500 border border-emerald-100",
                    icon: options.icon || "ri-checkbox-circle-line text-2xl",
                    btn: "inline-flex items-center justify-center px-4 py-2 text-sm font-satoshi-bold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-xl transition-all shadow-sm cursor-pointer"
                },
                warning: {
                    bg: "flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-500 border border-amber-100",
                    icon: options.icon || "ri-error-warning-line text-2xl",
                    btn: "inline-flex items-center justify-center px-4 py-2 text-sm font-satoshi-bold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-xl transition-all shadow-sm cursor-pointer"
                },
                primary: {
                    bg: "flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 border border-blue-100",
                    icon: options.icon || "ri-information-line text-2xl",
                    btn: "inline-flex items-center justify-center px-4 py-2 text-sm font-satoshi-bold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl transition-all shadow-sm cursor-pointer"
                },
                danger: {
                    bg: "flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-500 border border-rose-100",
                    icon: options.icon || "ri-alert-line text-2xl",
                    btn: "inline-flex items-center justify-center px-4 py-2 text-sm font-satoshi-bold text-white bg-rose-600 hover:bg-rose-700 active:bg-rose-800 rounded-xl transition-all shadow-sm cursor-pointer"
                }
            };

            const config = variantMap[variant] || variantMap.danger;

            if (iconBg) iconBg.className = config.bg;
            if (iconEl) iconEl.className = config.icon;
            if (btnEl) btnEl.className = config.btn;

            modal.classList.remove("opacity-0", "pointer-events-none");
            if (modalBox) modalBox.classList.remove("translate-y-4");
        }

        function closeConfirmModal() {
            const modal = document.getElementById("confirm-modal");
            if (!modal) return;
            const modalBox = modal.querySelector(".relative");

            modal.classList.add("opacity-0", "pointer-events-none");
            if (modalBox) modalBox.classList.add("translate-y-4");
            
            confirmModalCallback = null;
            confirmFormToSubmit = null;
        }
    </script>
    @endpush
@endonce

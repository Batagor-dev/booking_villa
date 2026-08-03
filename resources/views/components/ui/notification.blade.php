@php
    $type = null;
    $message = null;

    if (session()->has('success')) {
        $type = 'success';
        $message = session('success');
    } elseif (session()->has('error')) {
        $type = 'danger';
        $message = session('error');
    } elseif (session()->has('info')) {
        $type = 'info';
        $message = session('info');
    } elseif (session()->has('warning')) {
        $type = 'warning';
        $message = session('warning');
    }
@endphp

<!-- Toast Container (Always present in backend layout for JS toast triggers) -->
<div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-4 w-full max-w-md pointer-events-none">
    @if ($type && $message)
        <div 
            id="toast-notification-session"
            class="toast-notification flex w-full transform items-start gap-4 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-md transition-all duration-300 pointer-events-auto"
            data-toast-duration="4000"
        >
            {{-- Icon --}}
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $type === 'success' ? 'bg-emerald-50 text-emerald-500 border border-emerald-100' : ($type === 'danger' ? 'bg-rose-50 text-rose-500 border border-rose-100' : ($type === 'warning' ? 'bg-amber-50 text-amber-500 border border-amber-100' : 'bg-blue-50 text-blue-500 border border-blue-100')) }}">
                @if ($type === 'success')
                    <i class="ri-checkbox-circle-line text-xl"></i>
                @elseif ($type === 'danger')
                    <i class="ri-error-warning-line text-xl"></i>
                @elseif ($type === 'warning')
                    <i class="ri-alert-line text-xl"></i>
                @else
                    <i class="ri-information-line text-xl"></i>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 space-y-1 text-left">
                <h4 class="text-sm font-satoshi-bold text-slate-800 capitalize">
                    {{ $type === 'danger' ? 'error' : $type }}
                </h4>
                <p class="text-sm font-satoshi-medium text-slate-500 leading-relaxed">
                    {{ $message }}
                </p>
            </div>

            {{-- Close --}}
            <button 
                type="button" 
                onclick="closeToast(this.closest('.toast-notification'))" 
                class="text-slate-400 hover:text-slate-600 transition-colors"
            >
                <i class="ri-close-line text-lg"></i>
            </button>
        </div>
    @endif
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sessionToast = document.getElementById("toast-notification-session");
            if (sessionToast) {
                // Animate entry
                sessionToast.style.opacity = '0';
                sessionToast.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    sessionToast.style.opacity = '1';
                    sessionToast.style.transform = 'translateY(0)';
                }, 100);

                // Auto dismiss
                const duration = parseInt(sessionToast.getAttribute("data-toast-duration")) || 4000;
                setTimeout(() => {
                    closeToast(sessionToast);
                }, duration);
            }
            
            // Listen to dynamic toast event
            window.addEventListener('show-toast', (event) => {
                const { type, message } = event.detail || event;
                createToast(type, message);
            });
        });

        function createToast(type, message) {
            const container = document.getElementById("toast-container");
            if (!container) return;

            const typeClassMap = {
                success: { bg: 'bg-emerald-50 text-emerald-500 border border-emerald-100', icon: 'ri-checkbox-circle-line' },
                danger: { bg: 'bg-rose-50 text-rose-500 border border-rose-100', icon: 'ri-error-warning-line' },
                error: { bg: 'bg-rose-50 text-rose-500 border border-rose-100', icon: 'ri-error-warning-line' },
                warning: { bg: 'bg-amber-50 text-amber-500 border border-amber-100', icon: 'ri-alert-line' },
                info: { bg: 'bg-blue-50 text-blue-500 border border-blue-100', icon: 'ri-information-line' }
            };

            const config = typeClassMap[type] || typeClassMap.info;
            const displayType = type === 'danger' ? 'error' : type;

            const toast = document.createElement("div");
            toast.className = "toast-notification flex w-full transform items-start gap-4 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-md transition-all duration-300 pointer-events-auto opacity-0 -translate-y-2";
            
            toast.innerHTML = `
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl ${config.bg}">
                    <i class="${config.icon} text-xl"></i>
                </div>
                <div class="flex-1 space-y-1 text-left">
                    <h4 class="text-sm font-satoshi-bold text-slate-800 capitalize">${displayType}</h4>
                    <p class="text-sm font-satoshi-medium text-slate-500 leading-relaxed">${message}</p>
                </div>
                <button type="button" class="toast-close-btn text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="ri-close-line text-lg"></i>
                </button>
            `;

            container.appendChild(toast);

            // Click close listener
            toast.querySelector('.toast-close-btn').addEventListener('click', () => {
                closeToast(toast);
            });

            // Entry animation
            setTimeout(() => {
                toast.classList.remove("opacity-0", "-translate-y-2");
            }, 50);

            // Auto dismiss
            setTimeout(() => {
                closeToast(toast);
            }, 4000);
        }

        function closeToast(toastElement) {
            if (toastElement) {
                toastElement.classList.add("opacity-0", "-translate-y-2");
                setTimeout(() => {
                    toastElement.remove();
                }, 300);
            }
        }
    </script>
    @endpush
@endonce

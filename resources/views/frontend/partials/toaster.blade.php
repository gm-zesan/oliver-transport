<!-- Modern Floating Toaster Notification Container (Small, Compact, Light Theme) -->
<div id="toast-container" 
     class="fixed top-4 right-4 sm:right-6 z-[9999] flex flex-col gap-2 pointer-events-none max-w-xs sm:max-w-sm w-full select-none"
     aria-live="polite" 
     aria-atomic="true">
</div>

<script>
    (function() {
        const icons = {
            success: `<svg class="h-4 w-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                      </svg>`,
            error: `<svg class="h-4 w-4 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>`,
            warning: `<svg class="h-4 w-4 text-amber-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                      </svg>`,
            info: `<svg class="h-4 w-4 text-sky-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                   </svg>`
        };

        const themeStyles = {
            success: {
                iconBg: 'bg-emerald-50 border-emerald-200/80',
                badgeBg: 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                barBg: 'bg-emerald-500',
            },
            error: {
                iconBg: 'bg-rose-50 border-rose-200/80',
                badgeBg: 'bg-rose-50 text-rose-700 border-rose-200/60',
                barBg: 'bg-rose-500',
            },
            warning: {
                iconBg: 'bg-amber-50 border-amber-200/80',
                badgeBg: 'bg-amber-50 text-amber-700 border-amber-200/60',
                barBg: 'bg-amber-500',
            },
            info: {
                iconBg: 'bg-sky-50 border-sky-200/80',
                badgeBg: 'bg-sky-50 text-sky-700 border-sky-200/60',
                barBg: 'bg-sky-500',
            }
        };

        window.showToast = function(message, type = 'success', title = null, duration = 2800) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const safeType = ['success', 'error', 'warning', 'info'].includes(type) ? type : 'info';
            const style = themeStyles[safeType];
            const defaultTitle = title || safeType.toUpperCase();

            // Create compact light toast item
            const toast = document.createElement('div');
            toast.className = `pointer-events-auto transform transition-all duration-200 translate-x-full opacity-0 flex flex-col rounded-2xl bg-white/95 backdrop-blur-xl border border-slate-200/90 px-3.5 py-2.5 shadow-lg shadow-slate-900/10 text-slate-800 relative overflow-hidden`;

            toast.innerHTML = `
                <div class="flex items-center gap-2.5">
                    <div class="p-1 rounded-lg ${style.iconBg} border flex-shrink-0">
                        ${icons[safeType]}
                    </div>
                    <div class="flex-1 pr-1 min-w-0">
                        <div class="flex items-center gap-1.5 mb-0.5">
                            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-black uppercase tracking-wider border ${style.badgeBg}">
                                ${defaultTitle}
                            </span>
                        </div>
                        <p class="text-xs font-semibold text-slate-700 leading-snug break-words">
                            ${message}
                        </p>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 transition p-1 rounded-lg hover:bg-slate-100 flex-shrink-0 cursor-pointer" aria-label="Dismiss">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Progress Line -->
                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-slate-100">
                    <div class="progress-bar h-full ${style.barBg} transition-all ease-linear" style="width: 100%;"></div>
                </div>
            `;

            container.appendChild(toast);

            // Animate In
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            });

            // Progress bar animation
            const progressBar = toast.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.transitionDuration = `${duration}ms`;
                requestAnimationFrame(() => {
                    progressBar.style.width = '0%';
                });
            }

            // Dismiss function
            const dismiss = () => {
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 200);
            };

            // Close button click
            const closeBtn = toast.querySelector('button');
            if (closeBtn) {
                closeBtn.addEventListener('click', dismiss);
            }

            // Auto dismiss timer
            const timer = setTimeout(dismiss, duration);

            // Pause on hover
            toast.addEventListener('mouseenter', () => {
                clearTimeout(timer);
                if (progressBar) progressBar.style.animationPlayState = 'paused';
            });
        };

        // Auto trigger Laravel flash session toasts
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                window.showToast(@json(session('success')), 'success');
            @endif

            @if(session('status'))
                window.showToast(@json(session('status')), 'success');
            @endif

            @if(session('error'))
                window.showToast(@json(session('error')), 'error');
            @endif

            @if(session('warning'))
                window.showToast(@json(session('warning')), 'warning');
            @endif

            @if(session('info'))
                window.showToast(@json(session('info')), 'info');
            @endif
        });
    })();
</script>

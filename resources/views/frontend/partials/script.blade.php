<!-- Interactive Frontend Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile Navigation Toggle
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');

        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function () {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                menu.classList.toggle('hidden');
                if (openIcon) openIcon.classList.toggle('hidden');
                if (closeIcon) closeIcon.classList.toggle('hidden');
            });

            mobileLinks.forEach(link => {
                link.addEventListener('click', function () {
                    menu.classList.add('hidden');
                    if (openIcon) openIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                });
            });
        }
    });

    // Direction switcher in Hero section
    function switchHeroRoute(route) {
        const btnA = document.getElementById('tab-btn-route-a');
        const btnB = document.getElementById('tab-btn-route-b');
        const detailsA = document.getElementById('hero-route-a-details');
        const detailsB = document.getElementById('hero-route-b-details');

        if (!btnA || !btnB || !detailsA || !detailsB) return;

        if (route === 'route-a') {
            btnA.classList.add('bg-brand-green', 'text-white', 'shadow-xs');
            btnA.classList.remove('text-content-secondary');
            btnA.setAttribute('aria-selected', 'true');

            btnB.classList.remove('bg-brand-green', 'text-white', 'shadow-xs');
            btnB.classList.add('text-content-secondary');
            btnB.setAttribute('aria-selected', 'false');

            detailsA.classList.remove('hidden');
            detailsB.classList.add('hidden');
        } else {
            btnB.classList.add('bg-brand-green', 'text-white', 'shadow-xs');
            btnB.classList.remove('text-content-secondary');
            btnB.setAttribute('aria-selected', 'true');

            btnA.classList.remove('bg-brand-green', 'text-white', 'shadow-xs');
            btnA.classList.add('text-content-secondary');
            btnA.setAttribute('aria-selected', 'false');

            detailsB.classList.remove('hidden');
            detailsA.classList.add('hidden');
        }
    }
</script>

@stack('scripts')


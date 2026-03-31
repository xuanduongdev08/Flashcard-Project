{{--
    Theme Toggle Button Component
    Usage: <x-theme-toggle />
    Adds/removes the `dark` class on <html> and persists the choice to localStorage.
--}}
<button
    id="theme-toggle-btn"
    type="button"
    title="Chuyển đổi giao diện sáng/tối"
    onclick="toggleTheme()"
    class="relative w-10 h-10 flex items-center justify-center rounded-xl
           bg-slate-800/60 dark:bg-slate-700/60
           border border-slate-700/50 dark:border-slate-600/50
           text-slate-400 dark:text-slate-300
           hover:text-white dark:hover:text-white
           hover:bg-slate-700 dark:hover:bg-slate-600
           transition-all duration-200 hover:scale-110 active:scale-95
           shadow-sm hover:shadow-indigo-500/10"
    aria-label="Toggle dark mode">

    {{-- Sun Icon (shown in dark mode → click to go light) --}}
    <svg id="icon-sun"
         class="w-5 h-5 transition-all duration-300"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
    </svg>

    {{-- Moon Icon (shown in light mode → click to go dark) --}}
    <svg id="icon-moon"
         class="w-5 h-5 hidden transition-all duration-300"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
    </svg>
</button>

<script>
    // Sync icon state with current theme whenever this component is rendered
    (function syncToggleIcon() {
        const isDark = document.documentElement.classList.contains('dark');
        const sun  = document.getElementById('icon-sun');
        const moon = document.getElementById('icon-moon');
        if (!sun || !moon) return;
        if (isDark) {
            sun.classList.remove('hidden');   // dark mode → show sun (to switch to light)
            moon.classList.add('hidden');
        } else {
            sun.classList.add('hidden');      // light mode → show moon (to switch to dark)
            moon.classList.remove('hidden');
        }
    })();

    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');

        if (isDark) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
        // Re-sync icons
        const sun  = document.getElementById('icon-sun');
        const moon = document.getElementById('icon-moon');
        const nowDark = html.classList.contains('dark');
        if (nowDark) {
            sun.classList.remove('hidden');
            moon.classList.add('hidden');
        } else {
            sun.classList.add('hidden');
            moon.classList.remove('hidden');
        }
    }
</script>

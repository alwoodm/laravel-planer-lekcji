<!-- Floating theme toggle button -->
<div 
    x-data="{ 
        darkMode: document.documentElement.classList.contains('dark'),
        isHovered: false,
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.darkMode);
        }
    }"
    class="fixed bottom-8 right-8 z-50 opacity-80 hover:opacity-100"
    @mouseover="isHovered = true"
    @mouseleave="isHovered = false"
>
    <button
        @click="toggle()"
        type="button"
        class="p-3 rounded-full shadow-lg bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 
              hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500
              transition-all duration-300 transform hover:scale-110 backdrop-blur-sm"
        :class="{
            'scale-110': isHovered,
            'shadow-blue-300/50': !darkMode,
            'shadow-blue-500/30': darkMode
        }"
        title="{{ __('Przełącz tryb ciemny') }}"
    >
        <!-- Sun icon -->
        <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
        </svg>
        
        <!-- Moon icon -->
        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
            </path>
        </svg>
    </button>
</div>

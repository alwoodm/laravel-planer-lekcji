import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php',
        './resources/views/vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Przedmioty
                'subject': {
                    'math': {
                        DEFAULT: '#3b82f6',
                        dark: '#2563eb'
                    },
                    'polish': {
                        DEFAULT: '#10b981',
                        dark: '#059669'
                    },
                    'english': {
                        DEFAULT: '#8b5cf6',
                        dark: '#7c3aed'
                    },
                    'history': {
                        DEFAULT: '#f59e0b',
                        dark: '#d97706'
                    },
                    'geography': {
                        DEFAULT: '#84cc16',
                        dark: '#65a30d'
                    },
                    'biology': {
                        DEFAULT: '#22c55e',
                        dark: '#16a34a'
                    },
                    'chemistry': {
                        DEFAULT: '#ec4899',
                        dark: '#db2777'
                    },
                    'physics': {
                        DEFAULT: '#06b6d4',
                        dark: '#0891b2'
                    }
                }
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}

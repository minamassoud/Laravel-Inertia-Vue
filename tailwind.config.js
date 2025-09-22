/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                Montserrat: ["Montserrat", "sans-serif"]
            },
            keyframes: {
                'slide-up': {
                    '0%': {transform: 'translateY(100%)', opacity: '0'},
                    '100%': {transform: 'translateY(0)', opacity: '1'},
                },
                'slide-right': {
                    '0%': {transform: 'translateX(0)', opacity: '1'},
                    '100%': {transform: 'translateX(100%)', opacity: '0'},
                },
            },
            animation: {
                'slide-up': 'slide-up 0.4s ease-out forwards',
                'slide-right': 'slide-right 0.4s ease-out forwards',
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}


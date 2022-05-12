module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
  theme: {
    extend: {
        keyframes: {
            'largura-75': {
                '0%': {
                    width: '0'
                },
                '100%': {
                    width: '75%'
                },
                },
                'largura-25': {
                '0%': {
                    width: '0'
                },
                '100%': {
                    width: '25%'
                },
            }
        },
        animation: {
            'largura-75': 'largura-75 1s ease-out both',
            'largura-25': 'largura-25 1s ease-out both'
        }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

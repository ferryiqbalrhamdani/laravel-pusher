module.exports = {
    purge: ['./src/**/*.{vue,js,ts,jsx,tsx}'],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                poppins: "'Poppins'",
            },
            colors: {
                primary: {
                    default: '#1173F8',
                },
                'hint-of-red': '#F3EFEE',
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}

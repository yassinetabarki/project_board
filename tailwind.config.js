 // tailwind.config.js
module.exports = {
    theme: {
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
        },
        fontFamily: {
            display: ['Gilroy', 'sans-serif'],
            body: ['Graphik', 'sans-serif'],
        },
        borderWidth: {
            default: '1px',
            '0': '0',
            '2': '2px',
            '4': '4px',
        },
        extend: {
            colors: {
                'grey-light': '#F5F6F9',
                blue:'#47cdff',
                'blue-light':'#8ae2fe'
            },
            spacing: {
                '96': '24rem',
                '128': '32rem',
            }
        },
        backgroundColors: {
            page:'var(--page-background-color)',
            card:'var(--card-background-color)',
            button:'var(--button-background-color)'
        }
    }
}
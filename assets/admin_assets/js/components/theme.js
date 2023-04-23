let TowerThemeSwitcher = {
    themeIcons: {
        'light': 'bi-brightness-high-fill',
        'dark': 'bi-moon-stars-fill',
    },

    getPreferred: function() {
        let stored = localStorage.getItem('tower_theme');
        if(stored) {
            return stored;
        }

        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    },

    setTheme: function(theme) {
        if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme);
        }

        let icon = document.querySelector('#tower_theme_switcher_icon');
        if(icon) {
            icon.className = `bi ${this.themeIcons[theme]}`;
        }
    },

    toggleTheme: function() {
        let currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';

        let newTheme;
        if(currentTheme === 'light') {
            newTheme = 'dark';
        } else if(currentTheme === 'dark') {
            newTheme = 'light';
        }

        this.setTheme(newTheme);
        localStorage.setItem('tower_theme', newTheme);
    },

    init: function() {
        this.setTheme(this.getPreferred());

        let switcher = document.querySelector('#tower_theme_switcher');
        if(switcher) {
            switcher.addEventListener('click', () => this.toggleTheme());
        }
    },
};

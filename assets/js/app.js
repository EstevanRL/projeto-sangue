class ThemeController {
    constructor() {
        this.toggle = document.getElementById('themeToggle');
        this.icon = document.getElementById('themeIcon');
        this.label = document.getElementById('themeLabel');
        this.apply(document.documentElement.dataset.theme || 'light');
        this.toggle?.addEventListener('click', () => {
            const current = document.documentElement.dataset.theme || 'light';
            this.apply(current === 'dark' ? 'light' : 'dark');
        });
    }

    apply(theme) {
        const dark = theme === 'dark';
        document.documentElement.dataset.theme = dark ? 'dark' : 'light';
        try {
            localStorage.setItem('site-theme', dark ? 'dark' : 'light');
        } catch (error) {
            return;
        }
        if (this.icon) this.icon.textContent = dark ? '☀' : '☾';
        if (this.label) this.label.textContent = dark ? 'Tema claro' : 'Tema escuro';
        this.toggle?.setAttribute('aria-label', dark ? 'Mudar para tema claro' : 'Mudar para tema escuro');
    }
}

document.addEventListener('DOMContentLoaded', () => new ThemeController());

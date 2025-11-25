class ThemeSwitcher {
  constructor(target) {
    this.toggleBtn = null;

    if (typeof target === 'string') {
      this.toggleBtn = document.querySelector(target);
    }

    if (target instanceof HTMLElement) {
      this.toggleBtn = target;
    }

    if (!target) {
      throw new Error('No target element found');
    }

    // Apply theme on initialization
    this.applyTheme();

    // Listen for system theme changes (only if no explicit theme is set)
    if (window.matchMedia) {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (!localStorage.getItem('theme')) {
          this.applyTheme();
        }
      });
    }

    if (this.toggleBtn) {
      this.toggleBtn.addEventListener('click', () => this.toggle());
    }
  }

  toggle() {
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme === 'dark') {
      // Switch to light mode
      localStorage.setItem('theme', 'light');
    } else {
      // Switch to dark mode (default behavior)
      localStorage.setItem('theme', 'dark');
    }

    // Apply the theme immediately
    this.applyTheme();
  }

  applyTheme() {
    const theme = localStorage.getItem('theme');
    const htmlElement = document.documentElement;

    // Remove existing theme classes
    htmlElement.classList.remove('light', 'dark');

    if (theme === 'dark') {
      htmlElement.classList.add('dark');
    } else if (theme === 'light') {
      htmlElement.classList.add('light');
    } else {
      // No explicit theme set - check system preference
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        htmlElement.classList.add('dark');
      } else {
        htmlElement.classList.add('light');
      }
    }
  }
}

const themeSwitcher = {
  init() {
    const themeToggleBtn = document.querySelector('#theme-toggle-btn');

    if (themeToggleBtn) {
      new ThemeSwitcher(themeToggleBtn);
    }
  },
};

export default themeSwitcher;

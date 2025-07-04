/**
 * Sistema de Gerenciamento de Temas Dark/Light
 * Gerencia a troca de temas, persistência no localStorage e detecção de preferência do sistema
 */

class ThemeManager {
  constructor() {
    this.currentTheme = 'light';
    this.themeToggle = null;
    this.init();
  }

  init() {
    // Carregar tema salvo ou detectar preferência do sistema
    this.loadTheme();
    
    // Criar e adicionar o toggle de tema
    this.createThemeToggle();
    
    // Aplicar tema inicial
    this.applyTheme();
    
    // Detectar mudanças na preferência do sistema
    this.detectSystemPreference();
  }

  loadTheme() {
    // Tentar carregar do localStorage
    let savedTheme = localStorage.getItem('theme');
    
    // Se não houver no localStorage, tentar carregar do cookie
    if (!savedTheme) {
      const cookies = document.cookie.split(';');
      for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'theme') {
          savedTheme = value;
          break;
        }
      }
    }
    
    if (savedTheme && (savedTheme === 'light' || savedTheme === 'dark')) {
      this.currentTheme = savedTheme;
    } else {
      // Detectar preferência do sistema se não houver tema salvo
      this.currentTheme = this.getSystemPreference();
    }
  }

  getSystemPreference() {
    // Verificar se o navegador suporta prefers-color-scheme
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      return 'dark';
    }
    return 'light';
  }

  detectSystemPreference() {
    // Escutar mudanças na preferência do sistema
    if (window.matchMedia) {
      const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
      
      mediaQuery.addEventListener('change', (e) => {
        // Só aplicar se não houver tema salvo no localStorage
        if (!localStorage.getItem('theme')) {
          this.currentTheme = e.matches ? 'dark' : 'light';
          this.applyTheme();
          this.updateToggleState();
        }
      });
    }
  }

  createThemeToggle() {
    // Criar o elemento do toggle
    const toggle = document.createElement('div');
    toggle.className = 'theme-toggle';
    toggle.setAttribute('role', 'button');
    toggle.setAttribute('tabindex', '0');
    toggle.setAttribute('aria-label', 'Alternar entre tema claro e escuro');
    toggle.setAttribute('aria-pressed', this.currentTheme === 'dark');
    
    // Adicionar ícones com SVG modernos
    toggle.innerHTML = `
      <svg class="theme-toggle-icon sun" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2V4M12 20V22M4 12H2M6.31412 6.31412L4.8999 4.8999M17.6859 6.31412L19.1001 4.8999M6.31412 17.69L4.8999 19.1042M17.6859 17.69L19.1001 19.1042M22 12H20M17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <svg class="theme-toggle-icon moon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="theme-toggle-tooltip">Alternar tema</span>
    `;
    
    // Adicionar eventos
    toggle.addEventListener('click', () => this.toggleTheme());
    toggle.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        this.toggleTheme();
      }
    });
    
    this.themeToggle = toggle;
    
    // Adicionar ao header em uma posição melhor
    const header = document.querySelector('header');
    if (header) {
      // Criar container para o toggle
      const toggleContainer = document.createElement('div');
      toggleContainer.className = 'theme-toggle-container';
      header.appendChild(toggleContainer);
      toggleContainer.appendChild(toggle);
    }
  }

  toggleTheme() {
    this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
    this.saveTheme();
    this.applyTheme();
    this.updateToggleState();
    
    // Adicionar classe de transição
    document.body.classList.add('theme-transition');
    setTimeout(() => {
      document.body.classList.remove('theme-transition');
    }, 500);
  }

  applyTheme() {
    // Aplicar tema ao documento
    document.documentElement.setAttribute('data-theme', this.currentTheme);
    
    // Atualizar meta theme-color para mobile
    this.updateMetaThemeColor();
    
    // Disparar evento customizado
    this.dispatchThemeChangeEvent();
  }

  updateToggleState() {
    if (this.themeToggle) {
      this.themeToggle.setAttribute('aria-pressed', this.currentTheme === 'dark');
    }
  }

  saveTheme() {
    localStorage.setItem('theme', this.currentTheme);
    
    // Sincronizar com cookie para SSR
    const expires = new Date();
    expires.setFullYear(expires.getFullYear() + 1); // Cookie válido por 1 ano
    document.cookie = `theme=${this.currentTheme}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
  }

  updateMetaThemeColor() {
    // Atualizar cor do tema para mobile browsers
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    
    if (!metaThemeColor) {
      metaThemeColor = document.createElement('meta');
      metaThemeColor.name = 'theme-color';
      document.head.appendChild(metaThemeColor);
    }
    
    metaThemeColor.content = this.currentTheme === 'dark' ? '#0f0f0f' : '#171717';
  }

  dispatchThemeChangeEvent() {
    // Disparar evento para outros componentes
    const event = new CustomEvent('themeChange', {
      detail: { theme: this.currentTheme }
    });
    document.dispatchEvent(event);
  }

  // Métodos públicos para uso externo
  getCurrentTheme() {
    return this.currentTheme;
  }

  setTheme(theme) {
    if (theme === 'light' || theme === 'dark') {
      this.currentTheme = theme;
      this.saveTheme();
      this.applyTheme();
      this.updateToggleState();
    }
  }
}

// Inicializar o gerenciador de temas quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
  window.themeManager = new ThemeManager();
});

// Exportar para uso em outros módulos
if (typeof module !== 'undefined' && module.exports) {
  module.exports = ThemeManager;
} 
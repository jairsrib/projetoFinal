# Sistema de Temas Dark/Light

## Visão Geral

O sistema de temas implementado permite aos usuários alternar entre os temas claro e escuro em todas as páginas do projeto. O sistema é responsivo, acessível e persiste a preferência do usuário.

## Características

### ✅ Funcionalidades Implementadas

- **Toggle de Tema**: Botão no header para alternar entre dark/light
- **Persistência**: Salva preferência no localStorage e cookies
- **Detecção Automática**: Detecta preferência do sistema operacional
- **Responsividade**: Funciona em todos os tamanhos de tela
- **Acessibilidade**: Suporte a navegação por teclado e screen readers
- **Transições Suaves**: Animações elegantes entre temas
- **Compatibilidade**: Funciona em todos os navegadores modernos

### 🎨 Temas Disponíveis

#### Tema Light (Padrão)
- Fundo: Branco (#ffffff)
- Texto: Cinza escuro (#212529)
- Cards: Branco com sombras suaves
- Header: Escuro (mantido para contraste)

#### Tema Dark
- Fundo: Cinza muito escuro (#1a1a1a)
- Texto: Branco (#ffffff)
- Cards: Cinza escuro (#2d2d2d)
- Header: Preto (#0f0f0f)

## Arquivos do Sistema

### CSS
- `assets/theme.css` - Variáveis CSS e estilos do sistema de temas
- `assets/header.css` - Atualizado para usar variáveis do tema
- `assets/previsao.css` - Atualizado para usar variáveis do tema
- `assets/dashboard.css` - Atualizado para usar variáveis do tema
- `assets/painel_usuario.css` - Atualizado para usar variáveis do tema
- `assets/footer.css` - Atualizado para usar variáveis do tema
- `assets/contato.css` - Atualizado para usar variáveis do tema
- `assets/tela_login.css` - Atualizado para usar variáveis do tema
- `assets/form_cadastro.css` - Atualizado para usar variáveis do tema
- `assets/nova_noticia.css` - Atualizado para usar variáveis do tema
- `assets/lista_usuarios.css` - Atualizado para usar variáveis do tema

### JavaScript
- `assets/js/theme.js` - Gerenciador principal do sistema de temas

### PHP
- `config/theme_config.php` - Configurações e funções auxiliares

## Como Usar

### 1. Incluir em uma Nova Página

```php
<?php include_once 'config/theme_config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br" <?php echo getThemeDataAttribute(); ?>>
<head>
    <!-- Outros meta tags e CSS -->
    <link rel="stylesheet" href="assets/theme.css">
    <!-- Seus outros CSS -->
</head>
<body>
    <!-- Conteúdo da página -->
    
    <!-- Scripts -->
    <script src="assets/js/theme.js"></script>
    <!-- Outros scripts -->
</body>
</html>
```

### 2. Usar Variáveis CSS

```css
.minha-classe {
    background-color: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-primary);
    box-shadow: var(--shadow-primary);
}
```

### 3. JavaScript - Acessar o Tema

```javascript
// Obter tema atual
const temaAtual = window.themeManager.getCurrentTheme();

// Definir tema programaticamente
window.themeManager.setTheme('dark');

// Escutar mudanças de tema
document.addEventListener('themeChange', (event) => {
    console.log('Tema mudou para:', event.detail.theme);
});
```

## Variáveis CSS Disponíveis

### Cores de Fundo
- `--bg-primary` - Fundo principal
- `--bg-secondary` - Fundo secundário
- `--bg-tertiary` - Fundo terciário
- `--bg-header` - Fundo do header
- `--bg-sidebar` - Fundo da sidebar
- `--bg-card` - Fundo dos cards
- `--bg-input` - Fundo dos inputs

### Cores de Texto
- `--text-primary` - Texto principal
- `--text-secondary` - Texto secundário
- `--text-muted` - Texto atenuado
- `--text-white` - Texto branco
- `--text-header` - Texto do header
- `--text-accent` - Texto de destaque

### Bordas
- `--border-primary` - Borda principal
- `--border-secondary` - Borda secundária
- `--border-accent` - Borda de destaque
- `--border-sidebar` - Borda da sidebar

### Sombras
- `--shadow-primary` - Sombra principal
- `--shadow-secondary` - Sombra secundária
- `--shadow-card` - Sombra dos cards
- `--shadow-header` - Sombra do header

### Transições
- `--transition-fast` - Transição rápida (0.2s)
- `--transition-normal` - Transição normal (0.3s)
- `--transition-slow` - Transição lenta (0.5s)

## Acessibilidade

### Recursos Implementados
- **Navegação por Teclado**: Tab, Enter e Espaço funcionam no toggle
- **ARIA Labels**: Labels descritivos para screen readers
- **Contraste**: Cores com contraste adequado em ambos os temas
- **Redução de Movimento**: Respeita `prefers-reduced-motion`

### Exemplo de Uso Acessível
```html
<div class="theme-toggle" 
     role="button" 
     tabindex="0" 
     aria-label="Alternar entre tema claro e escuro"
     aria-pressed="false">
    <span class="theme-toggle-icon sun">☀️</span>
    <span class="theme-toggle-icon moon">🌙</span>
</div>
```

## Responsividade

### Breakpoints
- **Desktop**: Toggle no canto superior direito
- **Tablet (768px)**: Toggle reposicionado
- **Mobile (480px)**: Toggle com tamanho reduzido

### CSS Responsivo
```css
@media (max-width: 768px) {
    .previsao-do-tempo {
        position: relative;
        top: auto;
        right: auto;
        margin-top: 15px;
    }
}
```

## Persistência

### LocalStorage
```javascript
localStorage.setItem('theme', 'dark');
const tema = localStorage.getItem('theme');
```

### Cookies
```javascript
// Definido automaticamente pelo sistema
document.cookie = 'theme=dark; expires=...; path=/; SameSite=Lax';
```

## Detecção de Preferência do Sistema

### CSS Media Query
```css
@media (prefers-color-scheme: dark) {
    :root:not([data-theme]) {
        /* Aplicar tema dark automaticamente */
    }
}
```

### JavaScript
```javascript
if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    // Usuário prefere tema escuro
}
```

## Troubleshooting

### Problemas Comuns

1. **Tema não persiste**
   - Verificar se localStorage está habilitado
   - Verificar se cookies estão habilitados

2. **Transições não funcionam**
   - Verificar se `prefers-reduced-motion` está ativo
   - Verificar se CSS está carregado corretamente

3. **Toggle não aparece**
   - Verificar se `theme.js` está carregado
   - Verificar se `.btn-menu` existe no DOM

### Debug
```javascript
// Verificar estado do tema
console.log('Tema atual:', window.themeManager.getCurrentTheme());
console.log('localStorage:', localStorage.getItem('theme'));
console.log('Cookies:', document.cookie);
```

## Contribuição

Para adicionar novos temas ou modificar existentes:

1. Editar `assets/theme.css`
2. Adicionar novas variáveis CSS
3. Atualizar arquivos CSS específicos
4. Testar em diferentes dispositivos
5. Verificar acessibilidade

## Licença

Este sistema de temas é parte do projeto "Caiu o Servidor" e segue as mesmas diretrizes de licenciamento. 
# Sistema de Anúncios - Nova Versão

## Visão Geral

O novo sistema de anúncios foi completamente reformulado para oferecer uma experiência mais dinâmica e organizada. Agora os anúncios são exibidos de acordo com sua prioridade:

- **Prioridade Alta (1)**: Exibidos como pop-up modal
- **Outras Prioridades (2, 3)**: Exibidos em carrossel lateral alternado

## Funcionalidades

### 1. Pop-up de Anúncios de Prioridade Alta
- Aparece automaticamente após 2-5 segundos
- Modal centralizado com backdrop blur
- Botão de fechar e clique fora para fechar
- Não reaparece na mesma sessão após fechado
- Suporte a tecla ESC para fechar

### 2. Carrossel Lateral
- Posicionado no canto direito da tela
- Alterna automaticamente a cada 5 segundos
- Pausa quando o mouse está sobre o carrossel
- Indicadores visuais para navegação manual
- Botão de fechar individual para cada anúncio
- Desaparece quando todos os anúncios são fechados

## Estrutura do Banco de Dados

### Tabela `anuncio`
```sql
CREATE TABLE anuncio (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(255),
  imagem VARCHAR(255),
  link VARCHAR(255),
  texto VARCHAR(100),
  ativo TINYINT,
  destaque TINYINT,
  data_cadastro DATETIME,
  valor_anuncio DOUBLE,
  anunciante_id INT,
  prioridade INT DEFAULT 3,           -- NOVA COLUNA
  categoria VARCHAR(50) DEFAULT 'geral', -- NOVA COLUNA
  data_expiracao DATETIME NULL       -- NOVA COLUNA
);
```

### Prioridades
- **1**: Alta - Exibido como pop-up
- **2**: Média - Exibido no carrossel
- **3**: Baixa - Exibido no carrossel

## Arquivos do Sistema

### Backend
- `classes/AnuncioManager.php` - Gerenciamento de anúncios
- `includes/anuncios_sistema.php` - Renderização do sistema
- `atualizar_anuncios.sql` - Script para atualizar banco de dados

### Frontend
- `assets/anuncios_sistema.css` - Estilos do sistema
- `assets/js/anuncios_sistema.js` - Controle JavaScript

## Instalação

### 1. Atualizar Banco de Dados
Execute o script SQL para adicionar as novas colunas:

```sql
-- Executar o arquivo atualizar_anuncios.sql
```

### 2. Inserir Anúncios de Exemplo
```sql
INSERT INTO anuncio (nome, imagem, link, texto, ativo, destaque, data_cadastro, valor_anuncio, anunciante_id, prioridade, categoria) VALUES
('Anúncio Alta Prioridade', 'imagem.jpg', 'https://exemplo.com', 'Texto do anúncio', 1, 1, NOW(), 1000.00, 1, 1, 'lançamento'),
('Anúncio Média Prioridade', 'imagem2.jpg', 'https://exemplo.com', 'Texto do anúncio', 1, 0, NOW(), 500.00, 1, 2, 'promoção'),
('Anúncio Baixa Prioridade', 'imagem3.jpg', 'https://exemplo.com', 'Texto do anúncio', 1, 0, NOW(), 300.00, 1, 3, 'evento');
```

## Uso

### No Painel Admin
1. Acesse `admin/anuncios.php`
2. Crie ou edite anúncios
3. Defina a prioridade (1, 2 ou 3)
4. Configure categoria e outras propriedades

### Personalização
- **Cores**: Edite as variáveis CSS em `assets/anuncios_sistema.css`
- **Timing**: Modifique os intervalos no arquivo JavaScript
- **Posição**: Ajuste a posição do carrossel no CSS

## Responsividade

O sistema é totalmente responsivo:
- **Desktop**: Carrossel no lado direito, pop-up centralizado
- **Tablet**: Carrossel menor, pop-up adaptado
- **Mobile**: Carrossel compacto, pop-up otimizado

## Recursos Avançados

### Controle via JavaScript
```javascript
// Acessar o sistema
const sistema = window.anunciosSistema;

// Verificar dados
console.log(sistema.getAnuncioPopupData());
console.log(sistema.getAnunciosCarrosselData());

// Controle manual
sistema.fecharAnuncioPopup();
sistema.mostrarAnuncioCarrossel(0);
```

### Eventos Personalizados
```javascript
// Escutar mudanças no carrossel
document.addEventListener('carrosselChange', (e) => {
    console.log('Carrossel mudou para índice:', e.detail.index);
});
```

## Compatibilidade

- **Navegadores**: Chrome, Firefox, Safari, Edge (versões modernas)
- **Dispositivos**: Desktop, tablet, mobile
- **Temas**: Suporte completo aos temas dark/light

## Troubleshooting

### Pop-up não aparece
- Verificar se há anúncios com prioridade 1
- Verificar se não foi fechado na sessão atual
- Limpar localStorage se necessário

### Carrossel não funciona
- Verificar se há anúncios com prioridade > 1
- Verificar console para erros JavaScript
- Verificar se os arquivos CSS/JS estão carregados

### Problemas de Responsividade
- Verificar viewport meta tag
- Testar em diferentes tamanhos de tela
- Verificar media queries no CSS

## Migração do Sistema Antigo

O sistema antigo (`anuncios_render.php`) foi substituído. Para migrar:

1. Execute o script SQL de atualização
2. Atualize anúncios existentes com prioridades
3. Remova referências ao sistema antigo
4. Teste o novo sistema

## Suporte

Para dúvidas ou problemas:
1. Verificar logs do servidor
2. Verificar console do navegador
3. Testar com dados de exemplo
4. Verificar configurações do banco de dados 
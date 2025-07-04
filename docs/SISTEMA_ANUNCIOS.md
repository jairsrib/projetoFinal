# Sistema de Anúncios CRUD

## 📋 Visão Geral

Sistema completo de gerenciamento de anúncios implementado em PHP com armazenamento JSON, incluindo funcionalidades de destaque visual, popup promocional e painel administrativo.

## 🏗️ Arquitetura

### Estrutura de Arquivos

```
projetoFinal/
├── classes/
│   └── AnuncioManager.php          # Classe principal para gerenciar anúncios
├── api/
│   └── anuncios.php                # API REST para operações CRUD
├── admin/
│   └── anuncios.php                # Painel administrativo
├── includes/
│   └── anuncios_render.php         # Renderização dos anúncios
├── assets/
│   └── anuncios.css                # Estilos dos anúncios
├── data/
│   └── anuncios.json               # Banco de dados JSON
├── index.php                       # Página principal (integração)
├── teste_anuncios.html             # Página de demonstração
└── docs/
    └── SISTEMA_ANUNCIOS.md         # Esta documentação
```

## 🎯 Funcionalidades

### ✅ Implementadas

- **CRUD Completo**: Create, Read, Update, Delete de anúncios
- **Armazenamento JSON**: Banco de dados simples e eficiente
- **Sistema de Destaque**: Anúncios em destaque com efeitos visuais especiais
- **Popup Promocional**: Exibição aleatória de anúncios ativos
- **Categorização**: Sistema de categorias com cores diferenciadas
- **Controle de Status**: Ativo/Inativo para cada anúncio
- **Sistema de Prioridades**: Ordenação por prioridade (1-3)
- **Painel Administrativo**: Interface completa para gestão
- **API REST**: Endpoints para integração externa
- **Design Responsivo**: Adaptação a diferentes dispositivos
- **Integração com Temas**: Suporte aos temas dark/light
- **Validação de Dados**: Verificação de campos obrigatórios
- **Persistência Local**: Controle de popup via localStorage

### 🆕 Modal de Cadastro (NOVO)

- **Modal Integrado**: Acessível via sidebar do header
- **Formulário Completo**: Todos os campos necessários
- **Upload de Imagem**: Input de arquivo com preview
- **Validação em Tempo Real**: Feedback imediato ao usuário
- **Preview de Imagem**: Visualização da imagem antes do envio
- **Envio AJAX**: Processamento assíncrono sem recarregar página
- **Feedback Visual**: Notificações de sucesso/erro elegantes
- **Controle de Data**: Agendamento de anúncios futuros
- **Valor Monetário**: Campo para valor do anúncio
- **Design Responsivo**: Adaptação a mobile e desktop

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 7.4+
- **Banco de Dados**: JSON
- **Frontend**: HTML5, CSS3, JavaScript
- **Estilização**: CSS Variables, Flexbox, Grid
- **Animações**: CSS Animations, Transitions
- **API**: REST com CORS
- **Persistência**: LocalStorage

## 📊 Estrutura de Dados

### Campos do Anúncio

```json
{
  "id": 1,                           // ID único (auto-gerado)
  "nome": "Nome da Empresa",         // Nome da empresa (obrigatório, max 100 chars)
  "texto": "Slogan do anúncio",      // Texto/slogan (obrigatório, max 200 chars)
  "imagem": "https://exemplo.com/imagem.jpg", // URL da imagem (obrigatório)
  "link": "https://exemplo.com",     // URL de destino (obrigatório)
  "ativo": true,                     // Status ativo/inativo
  "destaque": false,                 // Destaque visual
  "data_cadastro": "2024-01-15T10:30:00Z", // Data de cadastro (obrigatório)
  "valorAnuncio": 1500.00,           // Valor do anúncio (decimal)
  "titulo": "Título do Anúncio",     // Título (legado)
  "descricao": "Descrição...",       // Descrição (legado)
  "data_criacao": "2024-01-15T10:30:00Z", // Data de criação (auto)
  "data_expiracao": "2024-12-31T23:59:59Z", // Data de expiração (opcional)
  "categoria": "lançamento",         // Categoria (geral, lançamento, promoção, etc.)
  "prioridade": 1                    // Prioridade (1=alta, 2=média, 3=baixa)
}
```

### Categorias Disponíveis

- `geral` - Categoria padrão
- `lançamento` - Novos lançamentos
- `promoção` - Ofertas e descontos
- `evento` - Eventos e competições
- `sistema` - Atualizações do sistema
- `comunidade` - Comunidade e interação

## 🚀 Como Usar

### 1. Visualização dos Anúncios

Os anúncios são exibidos automaticamente na página principal (`index.php`) na seção "Anúncios e Promoções".

**Características:**
- Exibe apenas anúncios ativos (`ativo = true`)
- Anúncios em destaque têm efeito visual especial
- Layout responsivo com grid adaptativo
- Categorias com cores diferenciadas

### 2. Popup Promocional

**Funcionamento:**
- Seleciona aleatoriamente um anúncio ativo
- Prioriza anúncios em destaque
- Aparece após 2-5 segundos do carregamento
- Pode ser fechado e não reaparece na sessão

**Controle:**
```javascript
// Verificar se popup foi fechado
localStorage.getItem('anuncio_popup_fechado') === 'true'

// Fechar popup
localStorage.setItem('anuncio_popup_fechado', 'true')
```

### 3. Modal de Cadastro (NOVO)

Acessível via sidebar do header em qualquer página.

**Como Usar:**
1. Clique no botão "Cadastrar Anúncio" no sidebar
2. Preencha os campos obrigatórios (marcados com *)
3. Insira URLs válidas para imagem e destino
4. Configure data de cadastro (pode ser futura para agendamento)
5. Defina valor do anúncio (opcional)
6. Marque/desmarque ativo e destaque conforme necessário
7. Clique em "Cadastrar Anúncio"

**Funcionalidades:**
- Upload de arquivo de imagem com preview
- Validação de tipo e tamanho de arquivo (máx 2MB)
- Validação em tempo real de URLs
- Preview da imagem do anúncio
- Feedback visual de campos obrigatórios
- Envio assíncrono via AJAX
- Notificações de sucesso/erro
- Controle de data para agendamento
- Design responsivo para mobile

### 4. Painel Administrativo

Acesse `admin/anuncios.php` para gerenciar anúncios.

**Funcionalidades:**
- Lista todos os anúncios em tabela
- Criar novo anúncio
- Editar anúncio existente
- Excluir anúncio
- Controle de status e destaque
- Validação de dados em tempo real

### 4. API REST

Endpoint: `api/anuncios.php`

**Métodos Disponíveis:**

#### GET - Listar Anúncios
```http
GET /api/anuncios.php
GET /api/anuncios.php?ativo=true
GET /api/anuncios.php?destaque=true
GET /api/anuncios.php?categoria=promoção
```

#### GET - Buscar Anúncio Específico
```http
GET /api/anuncios.php/1
```

#### POST - Criar Anúncio
```http
POST /api/anuncios.php
Content-Type: application/json

{
  "nome": "Nome da Empresa",
  "texto": "Slogan do anúncio",
  "imagem": "https://exemplo.com/imagem.jpg",
  "link": "https://exemplo.com/destino",
  "data_cadastro": "2024-01-15T10:30:00Z",
  "valorAnuncio": 1500.00,
  "ativo": true,
  "destaque": false,
  "categoria": "geral",
  "prioridade": 3
}
```

#### PUT - Atualizar Anúncio
```http
PUT /api/anuncios.php/1
Content-Type: application/json

{
  "titulo": "Título Atualizado",
  "ativo": false
}
```

#### DELETE - Excluir Anúncio
```http
DELETE /api/anuncios.php/1
```

## 🎨 Personalização

### Cores por Categoria

As categorias têm cores específicas definidas no CSS:

```css
.categoria-lancamento .anuncio-categoria span {
  background: linear-gradient(135deg, #667eea, #764ba2);
}

.categoria-promocao .anuncio-categoria span {
  background: linear-gradient(135deg, #f093fb, #f5576c);
}

.categoria-evento .anuncio-categoria span {
  background: linear-gradient(135deg, #4facfe, #00f2fe);
}
```

### Efeitos Visuais

**Anúncio em Destaque:**
- Borda colorida
- Animação de pulso
- Badge "⭐ Destaque"
- Background gradiente sutil

**Animações:**
- Slide-in ao carregar
- Hover effects
- Transições suaves
- Popup com fade-in

## 🔧 Configuração

### Validações Implementadas

#### Modal de Cadastro
- **Campos Obrigatórios**: Nome, imagem, link, texto, data de cadastro
- **Upload de Imagem**: Arquivo de imagem (JPG, PNG, GIF, WebP, máx 2MB)
- **URLs Válidas**: Validação de formato para destino
- **Limites de Caracteres**: Nome (100), texto (200)
- **Valor Positivo**: Valor do anúncio deve ser número positivo
- **Data Futura**: Data de cadastro pode ser futura (agendamento)

#### Validação Visual
- Campos com erro ficam vermelhos
- Campos válidos ficam verdes
- Feedback em tempo real
- Mensagens de erro específicas

### 1. Permissões de Arquivo

Certifique-se que o diretório `data/` tenha permissões de escrita:

```bash
chmod 755 data/
chmod 644 data/anuncios.json
```

### 2. Configuração do Servidor

O sistema funciona com qualquer servidor PHP (Apache, Nginx, etc.).

**Requisitos:**
- PHP 7.4 ou superior
- Extensão JSON habilitada
- Permissões de escrita no diretório data/

### 3. Integração com Sistema de Temas

O sistema já está integrado com o sistema de temas dark/light do projeto:

```css
/* Usa variáveis CSS do tema */
.anuncio-card {
  background: var(--card-bg);
  color: var(--text-color);
  border: 1px solid var(--border-color);
}
```

## 🧪 Testes

### Página de Demonstração

Acesse `teste_anuncios.html` para uma demonstração completa do sistema.

### Teste do Modal de Cadastro

Acesse `teste_cadastro_anuncio.html` para testar especificamente o modal de cadastro.

**Funcionalidades de Teste:**
- Abrir/fechar modal
- Validação de campos obrigatórios
- Upload e preview de imagem
- Envio via AJAX
- Feedback de sucesso/erro

### Teste de Upload da API

Acesse `teste_api_upload.html` para testar especificamente o upload de imagens na API.

**Funcionalidades de Teste:**
- Upload de arquivo de imagem
- Preview da imagem selecionada
- Envio via FormData
- Resposta detalhada da API
- Logs de debug no console

### Testes Manuais

1. **Criar Anúncio via Modal:**
   - Acesse qualquer página com o header
   - Clique em "Cadastrar Anúncio" no sidebar
   - Preencha os campos obrigatórios
   - Teste validação de URLs
   - Envie e verifique feedback
   - Confirme criação na página principal

2. **Criar Anúncio via Painel Admin:**
   - Acesse o painel admin
   - Clique em "Novo Anúncio"
   - Preencha os campos obrigatórios
   - Salve e verifique na página principal

2. **Testar Popup:**
   - Recarregue a página principal
   - Aguarde 2-5 segundos
   - Verifique se o popup aparece
   - Feche e recarregue (não deve aparecer novamente)

3. **Testar API:**
   ```bash
   # Listar anúncios
   curl http://localhost/projetoFinal/api/anuncios.php
   
   # Criar anúncio
   curl -X POST http://localhost/projetoFinal/api/anuncios.php \
     -H "Content-Type: application/json" \
     -d '{"titulo":"Teste","descricao":"Teste"}'
   ```

## 🐛 Solução de Problemas

### Problemas Comuns

1. **Anúncios não aparecem:**
   - Verifique se `ativo = true`
   - Confirme permissões do arquivo JSON
   - Verifique logs de erro do PHP

2. **Popup não funciona:**
   - Verifique se há anúncios ativos
   - Limpe localStorage: `localStorage.removeItem('anuncio_popup_fechado')`
   - Verifique console para erros JavaScript

3. **Erro de permissão:**
   ```bash
   chmod 755 data/
   chmod 644 data/anuncios.json
   ```

4. **API retorna erro:**
   - Verifique se o arquivo JSON é válido
   - Confirme permissões de escrita
   - Verifique logs do servidor

### Logs e Debug

Adicione logs para debug:

```php
// Em AnuncioManager.php
error_log("Criando anúncio: " . json_encode($dados));
```

## 📈 Melhorias Futuras

### Sugestões de Implementação

1. **Upload de Imagens:**
   - Sistema de upload de arquivos
   - Redimensionamento automático
   - Otimização de imagens

2. **Analytics:**
   - Contagem de visualizações
   - Métricas de clique
   - Relatórios de performance

3. **Agendamento:**
   - Agendar publicação
   - Agendar expiração
   - Cron jobs automáticos

4. **Notificações:**
   - Email de notificação
   - Push notifications
   - Integração com redes sociais

5. **Cache:**
   - Cache de anúncios
   - Otimização de performance
   - CDN para imagens

## 📞 Suporte

Para dúvidas ou problemas:

1. Verifique esta documentação
2. Consulte os logs de erro
3. Teste com dados mínimos
4. Verifique compatibilidade do PHP

---

**Desenvolvido com ❤️ para o projeto "Caiu o Servidor"** 
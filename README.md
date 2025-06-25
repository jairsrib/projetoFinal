# Caiu o Servidor - Portal de Notícias de Games

Bem-vindo ao **Caiu o Servidor**, um portal completo para divulgação, leitura e gerenciamento de notícias do universo dos games e e-sports!

## 📋 Descrição do Projeto

O projeto é um sistema web de notícias voltado para o mundo dos games, permitindo que usuários se cadastrem, publiquem, editem e acompanhem notícias sobre E-Sports, Speed-Run, Battle-Royale, RPG e muito mais. O sistema conta com painel de usuário, controle de perfis, upload de imagens, painel administrativo e interface moderna.

## 🚀 Funcionalidades Principais

- Cadastro e login de usuários
- Recuperação e alteração de senha
- Edição de perfil e upload de foto de perfil
- Publicação, edição e exclusão de notícias (admin/autores)
- Visualização de notícias em destaque e por categoria
- Painel de usuário com gerenciamento de notícias próprias
- Listagem de usuários (admin)
- Interface responsiva e moderna

## 🛠️ Tecnologias Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript (puro)
- **Backend:** PHP 7+
- **Banco de Dados:** MySQL
- **Bibliotecas e Frameworks:**
  - Bootstrap 5 (CDN)
  - Font Awesome (ícones)
- **Outros:**
  - PDO para acesso seguro ao banco de dados
  - Upload e manipulação de imagens

## 📂 Estrutura de Pastas

```
projetoFinal/
  ├── assets/           # CSS, JS e imagens
  ├── classes/          # Classes PHP (Usuário, Notícia, Database)
  ├── config/           # Configurações do banco
  ├── uploads/          # Imagens de notícias e perfis
  ├── ...               # Páginas PHP do sistema
```

## ⚙️ Como Executar Localmente

1. **Clone o repositório:**
   ```
   git clone <url-do-repositorio>
   ```
2. **Configure o banco de dados:**
   - Crie um banco MySQL chamado `projeto_final`.
   - Importe a estrutura e dados iniciais (veja instruções ou script SQL fornecido).
   - Ajuste as credenciais em `config/config.php` se necessário.
3. **Coloque o projeto em um servidor local** (ex: XAMPP, WAMP, Laragon) e acesse via navegador.
4. **Acesse:**
   - `http://localhost/projetoFinal/login.php` para login
   - `http://localhost/projetoFinal/cadastro.php` para cadastro

## 👤 Créditos

Desenvolvido por:
- Leonardo Verardo
- Jair de Souza

---

Sinta-se à vontade para contribuir, sugerir melhorias ou reportar problemas!

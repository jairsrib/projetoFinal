# 📧 Guia do FormSubmit

## O que é FormSubmit?

O FormSubmit é um serviço gratuito que permite enviar emails através de formulários HTML sem precisar de configuração de servidor ou backend. É perfeito para projetos simples e protótipos.

## ✅ Vantagens

- **Gratuito** - Sem custos
- **Simples** - Não precisa de configuração de servidor
- **Confiável** - Funciona em qualquer hospedagem
- **Seguro** - Proteção contra spam incluída
- **Flexível** - Muitas opções de configuração

## 🔧 Como Funciona

### 1. Configuração Atual

O formulário está configurado para enviar emails para: `jair.ribeiro.souza@gmail.com`

### 2. Primeiro Uso

Na primeira vez que alguém enviar um email, o FormSubmit enviará um email de confirmação para `jair.ribeiro.souza@gmail.com`. Você precisa clicar no link de confirmação para ativar o serviço.

### 3. Funcionamento

Após a confirmação, todos os emails do formulário serão enviados automaticamente para o email configurado.

## 📝 Configuração

### Arquivo de Configuração

O arquivo `config/formsubmit_config.php` contém todas as configurações:

```php
// Email de destino
define('FORMSUBMIT_EMAIL', 'jair.ribeiro.souza@gmail.com');

// URL de redirecionamento após envio
define('FORMSUBMIT_REDIRECT', 'http://localhost/projetoFinal/contato.php');

// Assunto dos emails
define('FORMSUBMIT_SUBJECT', 'Nova mensagem de contato do site');
```

### Para Mudar o Email

1. Edite o arquivo `config/formsubmit_config.php`
2. Mude a linha:
   ```php
   define('FORMSUBMIT_EMAIL', 'seu-novo-email@gmail.com');
   ```
3. Salve o arquivo

### Para Mudar a URL de Redirecionamento

1. Edite o arquivo `config/formsubmit_config.php`
2. Mude a linha:
   ```php
   define('FORMSUBMIT_REDIRECT', 'http://seudominio.com/contato.php');
   ```
3. Salve o arquivo

## 🎯 Opções Avançadas

### Campos Hidden Disponíveis

- `_next` - URL de redirecionamento após envio
- `_subject` - Assunto do email
- `_captcha` - Ativar/desativar captcha
- `_honey` - Proteção contra spam (honeypot)
- `_template` - Template personalizado do email

### Exemplo de Configuração Avançada

```php
// Ativar captcha
define('FORMSUBMIT_CAPTCHA', true);

// Usar template personalizado
define('FORMSUBMIT_TEMPLATE', 'table');

// Adicionar campos customizados
define('FORMSUBMIT_CUSTOM_FIELDS', array(
    '_replyto' => 'email',
    '_cc' => 'copia@email.com'
));
```

## 🚀 Como Testar

1. Acesse `http://localhost/projetoFinal/contato.php`
2. Preencha o formulário
3. Clique em "Enviar Mensagem"
4. Verifique se o email chegou

## 📧 Formato do Email Recebido

O email recebido terá este formato:

```
Assunto: Nova mensagem de contato do site

Nome: [Nome do usuário]
Email: [Email do usuário]
Mensagem: [Mensagem do usuário]
```

## 🔒 Segurança

O FormSubmit inclui:
- Proteção contra spam
- Validação de email
- Rate limiting
- Honeypot protection

## 🌐 Para Produção

Quando for para produção, lembre-se de:

1. Mudar a URL de redirecionamento para o domínio real
2. Configurar um email válido
3. Testar o formulário no ambiente de produção

## 📞 Suporte

- **Documentação oficial**: https://formsubmit.co/
- **Limites gratuitos**: 1000 emails por mês
- **Planos pagos**: Disponível para mais volume

## 🎉 Pronto!

Agora seu formulário de contato funciona sem precisar de configuração de servidor. É só testar e usar! 
// ===== SISTEMA DE CADASTRO DE ANÚNCIOS =====

// Variáveis globais
let modalCadastro = null;
let formCadastro = null;
let feedbackMessage = null;

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    initializeCadastroAnuncio();
});

function initializeCadastroAnuncio() {
    modalCadastro = document.getElementById('modal-cadastro-anuncio');
    formCadastro = document.getElementById('form-cadastro-anuncio');
    feedbackMessage = document.getElementById('feedback-message');
    
    // Definir data atual como padrão
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    document.getElementById('data_cadastro').value = localDateTime;
    
    // Event listeners
    setupEventListeners();
    
    // Inicializar ícones Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function setupEventListeners() {
    // Fechar modal ao clicar fora
    modalCadastro.addEventListener('click', function(e) {
        if (e.target === modalCadastro) {
            fecharModalCadastroAnuncio();
        }
    });
    
    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalCadastro.classList.contains('show')) {
            fecharModalCadastroAnuncio();
        }
    });
    
    // Submissão do formulário
    formCadastro.addEventListener('submit', handleFormSubmit);
    
    // Preview da imagem
    document.getElementById('imagem').addEventListener('change', handleImagePreview);
    
    // Validação em tempo real
    setupRealTimeValidation();
}

// ===== FUNÇÕES DO MODAL =====

function abrirModalCadastroAnuncio() {
    if (!modalCadastro) return;
    
    // Limpar formulário
    formCadastro.reset();
    
    // Definir data atual
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    document.getElementById('data_cadastro').value = localDateTime;
    
    // Mostrar modal
    modalCadastro.style.display = 'flex';
    setTimeout(() => {
        modalCadastro.classList.add('show');
    }, 10);
    
    // Focar no primeiro campo
    document.getElementById('nome').focus();
    
    // Limpar feedback anterior
    hideFeedback();
}

function fecharModalCadastroAnuncio() {
    if (!modalCadastro) return;
    
    modalCadastro.classList.remove('show');
    setTimeout(() => {
        modalCadastro.style.display = 'none';
    }, 300);
    
    // Limpar formulário
    formCadastro.reset();
    hideFeedback();
}

// ===== HANDLERS =====

function handleFormSubmit(e) {
    e.preventDefault();
    
    // Validar formulário
    if (!validateForm()) {
        showFeedback('Por favor, preencha todos os campos obrigatórios.', 'erro');
        return;
    }
    
    // Coletar dados do formulário
    const formData = collectFormData();
    
    // Enviar via AJAX
    submitForm(formData);
}

function handleImagePreview(e) {
    const file = e.target.files[0];
    const previewContainer = document.querySelector('.image-preview');
    
    if (!previewContainer) {
        // Criar container de preview se não existir
        const container = document.createElement('div');
        container.className = 'image-preview hidden';
        container.innerHTML = '<img src="" alt="Preview da imagem">';
        e.target.parentNode.appendChild(container);
    }
    
    if (file) {
        // Validar tipo de arquivo
        if (!file.type.startsWith('image/')) {
            showFeedback('Por favor, selecione apenas arquivos de imagem.', 'erro');
            e.target.value = '';
            document.querySelector('.image-preview').classList.add('hidden');
            return;
        }
        
        // Validar tamanho (2MB)
        if (file.size > 2 * 1024 * 1024) {
            showFeedback('A imagem deve ter no máximo 2MB.', 'erro');
            e.target.value = '';
            document.querySelector('.image-preview').classList.add('hidden');
            return;
        }
        
        // Criar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('.image-preview img');
            img.src = e.target.result;
            document.querySelector('.image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
        
        // Remover erro visual
        e.target.classList.remove('error');
    } else {
        document.querySelector('.image-preview').classList.add('hidden');
    }
}

// ===== VALIDAÇÃO =====

function validateForm() {
    const requiredFields = ['nome', 'imagem', 'link', 'texto', 'data_cadastro'];
    
    for (let field of requiredFields) {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            highlightField(element, true);
            return false;
        } else {
            highlightField(element, false);
        }
    }
    
    // Validar imagem
    const imageFile = document.getElementById('imagem').files[0];
    const linkUrl = document.getElementById('link').value;
    
    if (!imageFile) {
        showFeedback('Por favor, selecione uma imagem.', 'erro');
        return false;
    }
    
    if (!imageFile.type.startsWith('image/')) {
        showFeedback('Por favor, selecione apenas arquivos de imagem.', 'erro');
        return false;
    }
    
    if (imageFile.size > 2 * 1024 * 1024) {
        showFeedback('A imagem deve ter no máximo 2MB.', 'erro');
        return false;
    }
    
    if (!isValidUrl(linkUrl)) {
        showFeedback('URL de destino deve ser válida.', 'erro');
        return false;
    }
    
    return true;
}

function setupRealTimeValidation() {
    const fields = ['nome', 'link', 'texto'];
    
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('blur', () => {
                validateField(field);
            });
            
            field.addEventListener('input', () => {
                if (field.classList.contains('error')) {
                    validateField(field);
                }
            });
        }
    });
    
    // Validação especial para arquivo de imagem
    const imageField = document.getElementById('imagem');
    if (imageField) {
        imageField.addEventListener('change', () => {
            validateImageField(imageField);
        });
    }
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    
    switch (field.id) {
        case 'nome':
            isValid = value.length > 0 && value.length <= 100;
            break;
        case 'link':
            isValid = value.length > 0 && isValidUrl(value);
            break;
        case 'texto':
            isValid = value.length > 0 && value.length <= 200;
            break;
    }
    
    highlightField(field, !isValid);
    return isValid;
}

function validateImageField(field) {
    const file = field.files[0];
    let isValid = true;
    
    if (!file) {
        isValid = false;
    } else if (!file.type.startsWith('image/')) {
        isValid = false;
    } else if (file.size > 2 * 1024 * 1024) {
        isValid = false;
    }
    
    highlightField(field, !isValid);
    return isValid;
}

function highlightField(field, isError) {
    if (isError) {
        field.classList.add('error');
        field.style.borderColor = '#f44336';
    } else {
        field.classList.remove('error');
        field.style.borderColor = '';
    }
}

function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

// ===== COLETA DE DADOS =====

function collectFormData() {
    const formData = new FormData(formCadastro);
    
    // Converter checkboxes para boolean
    formData.set('ativo', document.getElementById('ativo').checked);
    formData.set('destaque', document.getElementById('destaque').checked);
    
    // Converter valores numéricos
    const valorAnuncio = parseFloat(document.getElementById('valorAnuncio').value) || 0.00;
    const prioridade = parseInt(document.getElementById('prioridade').value) || 3;
    formData.set('valorAnuncio', valorAnuncio);
    formData.set('prioridade', prioridade);
    
    // Converter datas para formato ISO
    const dataCadastro = document.getElementById('data_cadastro').value;
    const dataExpiracao = document.getElementById('data_expiracao').value;
    
    if (dataCadastro) {
        formData.set('data_cadastro', new Date(dataCadastro).toISOString());
    }
    
    if (dataExpiracao) {
        formData.set('data_expiracao', new Date(dataExpiracao).toISOString());
    }
    
    return formData;
}

// ===== AJAX =====

function submitForm(data) {
    const submitBtn = document.querySelector('.btn-salvar');
    
    // Mostrar loading
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
    
    // Fazer requisição AJAX
    fetch('api/anuncios.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(result => {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
        
        if (result.success) {
            showFeedback('Anúncio cadastrado com sucesso!', 'sucesso');
            setTimeout(() => {
                fecharModalCadastroAnuncio();
                // Recarregar página para mostrar o novo anúncio
                window.location.reload();
            }, 2000);
        } else {
            showFeedback(result.message || 'Erro ao cadastrar anúncio.', 'erro');
        }
    })
    .catch(error => {
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
        console.error('Erro:', error);
        showFeedback('Erro de conexão. Tente novamente.', 'erro');
    });
}

// ===== FEEDBACK =====

function showFeedback(message, type = 'info') {
    if (!feedbackMessage) return;
    
    feedbackMessage.textContent = message;
    feedbackMessage.className = `feedback-message ${type}`;
    feedbackMessage.classList.add('show');
    
    // Auto-hide após 5 segundos
    setTimeout(() => {
        hideFeedback();
    }, 5000);
}

function hideFeedback() {
    if (!feedbackMessage) return;
    
    feedbackMessage.classList.remove('show');
}

// ===== UTILITÁRIOS =====

function formatCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('pt-BR');
}

// ===== EXPOSIÇÃO DE FUNÇÕES GLOBAIS =====

// Funções que precisam ser acessíveis globalmente
window.abrirModalCadastroAnuncio = abrirModalCadastroAnuncio;
window.fecharModalCadastroAnuncio = fecharModalCadastroAnuncio; 
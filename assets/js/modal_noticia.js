function testarModal() {
    console.log('Função de teste chamada!');
    
    const modal = document.getElementById('modalNoticia');
    console.log('Modal encontrado:', modal);
    
    if (modal) {
        modal.classList.add('show');
        modal.style.display = 'flex';
        console.log('Modal display definido como flex');
        
        setTimeout(() => {
            const modalContent = modal.querySelector('.modal-content-custom');
            if (modalContent) {
                modalContent.classList.add('show');
                modalContent.style.transform = 'scale(1)';
                modalContent.style.opacity = '1';
                console.log('Modal animado');
            } else {
                console.log('Modal content não encontrado');
            }
        }, 10);
    } else {
        console.log('Modal NÃO encontrado!');
        alert('Modal NÃO encontrado! Verifique se o HTML está correto.');
    }
}

function abrirModalNoticia(id, titulo, texto, categoria, imagem, data) {
    console.log('Função abrirModalNoticia chamada com:', { id, titulo, categoria, imagem, data });
    
    const modal = document.getElementById('modalNoticia');
    const modalImg = document.getElementById('modalNoticiaImg');
    const modalTitulo = document.getElementById('modalNoticiaTitulo');
    const modalTexto = document.getElementById('modalNoticiaTexto');
    const modalCategoriaText = document.getElementById('modalNoticiaCategoriaText');
    const modalTempoText = document.getElementById('modalNoticiaTempoText');
    
    console.log('Elementos do modal:', { modal, modalImg, modalTitulo, modalTexto, modalCategoriaText, modalTempoText });
    
    if (!modal) {
        console.error('Modal não encontrado!');
        return;
    }
    
    modalImg.src = 'uploads/' + imagem;
    modalTitulo.textContent = titulo;
    modalTexto.textContent = texto;
    modalCategoriaText.textContent = categoria;
    
    const dataNoticia = new Date(data);
    const agora = new Date();
    const diffMs = agora - dataNoticia;
    const diffHoras = Math.floor(diffMs / (1000 * 60 * 60));
    const diffDias = Math.floor(diffHoras / 24);
    
    if (diffDias > 0) {
        modalTempoText.textContent = `Há ${diffDias} dia${diffDias > 1 ? 's' : ''}`;
    } else if (diffHoras > 0) {
        modalTempoText.textContent = `Há ${diffHoras} hora${diffHoras > 1 ? 's' : ''}`;
    } else {
        modalTempoText.textContent = 'Agora mesmo';
    }
    
    document.getElementById('modalNoticiaViews').textContent = Math.floor(Math.random() * 5000) + 100;
    document.getElementById('modalNoticiaComments').textContent = Math.floor(Math.random() * 50) + 5;
    document.getElementById('modalNoticiaLikes').textContent = Math.floor(Math.random() * 200) + 10;
    
    modal.classList.add('show');
    modal.style.display = 'flex';
    setTimeout(() => {
        const modalContent = modal.querySelector('.modal-content-custom');
        if (modalContent) {
            modalContent.classList.add('show');
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        }
    }, 10);
    
    document.body.style.overflow = 'hidden';
    
    document.addEventListener('keydown', fecharComEsc);
    
    console.log('Modal aberto com sucesso');
}

function fecharModalNoticia() {
    const modal = document.getElementById('modalNoticia');
    const modalContent = modal.querySelector('.modal-content-custom');
    
    modalContent.classList.remove('show');
    modalContent.style.transform = 'scale(0.9)';
    modalContent.style.opacity = '0';
    
    setTimeout(() => {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        document.removeEventListener('keydown', fecharComEsc);
    }, 300);
}

function fecharComEsc(event) {
    if (event.key === 'Escape') {
        fecharModalNoticia();
    }
}

function curtirNoticia() {
    const btnLike = document.querySelector('.btn-like');
    const likesSpan = document.getElementById('modalNoticiaLikes');
    const currentLikes = parseInt(likesSpan.textContent);
    
    if (btnLike.classList.contains('liked')) {
        btnLike.classList.remove('liked');
        btnLike.innerHTML = '<i class="fas fa-heart me-2"></i>Curtir';
        likesSpan.textContent = currentLikes - 1;
        
        mostrarNotificacao('Curtida removida!', 'info');
    } else {
        btnLike.classList.add('liked');
        btnLike.innerHTML = '<i class="fas fa-heart me-2"></i>Curtido';
        likesSpan.textContent = currentLikes + 1;
        
        mostrarNotificacao('Notícia curtida!', 'success');
    }
}

function compartilharNoticia() {
    const titulo = document.getElementById('modalNoticiaTitulo').textContent;
    const url = window.location.href;
    
    if (navigator.share) {
        navigator.share({
            title: titulo,
            url: url
        }).then(() => {
            mostrarNotificacao('Compartilhado com sucesso!', 'success');
        }).catch(() => {
            copiarParaClipboard(url);
        });
    } else {
        copiarParaClipboard(url);
    }
}

function copiarParaClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            mostrarNotificacao('Link copiado para a área de transferência!', 'success');
        }).catch(() => {
            fallbackCopyTextToClipboard(text);
        });
    } else {
        fallbackCopyTextToClipboard(text);
    }
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        mostrarNotificacao('Link copiado para a área de transferência!', 'success');
    } catch (err) {
        mostrarNotificacao('Erro ao copiar link', 'error');
    }
    
    document.body.removeChild(textArea);
}

function mostrarNotificacao(mensagem, tipo) {
    const notificacaoExistente = document.querySelector('.notificacao-toast');
    if (notificacaoExistente) {
        notificacaoExistente.remove();
    }
    
    const notificacao = document.createElement('div');
    notificacao.className = `notificacao-toast notificacao-${tipo}`;
    notificacao.innerHTML = `
        <div class="notificacao-content">
            <i class="fas ${getIconeNotificacao(tipo)}"></i>
            <span>${mensagem}</span>
        </div>
    `;
    
    document.body.appendChild(notificacao);
    
    setTimeout(() => {
        notificacao.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        notificacao.classList.remove('show');
        setTimeout(() => {
            if (notificacao.parentNode) {
                notificacao.remove();
            }
        }, 300);
    }, 3000);
}

function getIconeNotificacao(tipo) {
    switch (tipo) {
        case 'success':
            return 'fa-check-circle';
        case 'error':
            return 'fa-exclamation-circle';
        case 'warning':
            return 'fa-exclamation-triangle';
        case 'info':
            return 'fa-info-circle';
        default:
            return 'fa-bell';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado, configurando modal...');
    
    const modal = document.getElementById('modalNoticia');
    if (modal) {
        console.log('Modal encontrado no DOMContentLoaded');
        
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                fecharModalNoticia();
            }
        });
    } else {
        console.error('Modal NÃO encontrado no DOMContentLoaded!');
    }
    
    window.testarModal = testarModal;
    window.abrirModalNoticia = abrirModalNoticia;
    window.fecharModalNoticia = fecharModalNoticia;
    window.curtirNoticia = curtirNoticia;
    window.compartilharNoticia = compartilharNoticia;
    
    console.log('Funções do modal configuradas globalmente');
}); 
function abrirModalCadastrar() {
  document.getElementById('modalNoticia').style.display = 'flex';
  setTimeout(() => {
    document.querySelector('.modal-content-custom').style.transform = 'scale(1)';
    document.querySelector('.modal-content-custom').style.opacity = '1';
  }, 10);
}

function fecharModalCadastrar() {
  const modal = document.getElementById('modalNoticia');
  const content = document.querySelector('.modal-content-custom');
  
  content.style.transform = 'scale(0.9)';
  content.style.opacity = '0';
  
  setTimeout(() => {
    modal.style.display = 'none';
    content.style.transform = 'scale(1)';
    content.style.opacity = '1';
  }, 300);
}

function abrirModalEditar() {
  const selecionados = document.querySelectorAll('input[name="noticias_selecionadas[]"]:checked');

  if (selecionados.length !== 1) {
    const message = selecionados.length === 0 ? 
      "Por favor, selecione uma notícia para editar." : 
      "Por favor, selecione apenas uma notícia para editar.";
    
    showNotification(message, 'warning');
    return;
  }

  const noticia = selecionados[0];
  
  document.getElementById('modalEditar').style.display = 'flex';
  
  setTimeout(() => {
    document.querySelector('#modalEditar .modal-content-custom').style.transform = 'scale(1)';
    document.querySelector('#modalEditar .modal-content-custom').style.opacity = '1';
  }, 10);
  
  document.getElementById('idsNoticiasSelecionadas').value = noticia.value;
  document.getElementById('titulo').value = noticia.dataset.titulo || '';
  document.getElementById('texto').value = noticia.dataset.texto || '';
  
  const selectCategoria = document.querySelector('#modalEditar select[name="categoria"]');
  const categoriaValue = noticia.dataset.categoria;
  if (categoriaValue && categoriaValue !== 'null' && categoriaValue !== '') {
    selectCategoria.value = categoriaValue.toString();
  } else {
    selectCategoria.value = '';
  }
}

function fecharModalEditar() {
  const modal = document.getElementById('modalEditar');
  const content = document.querySelector('#modalEditar .modal-content-custom');
  
  content.style.transform = 'scale(0.9)';
  content.style.opacity = '0';
  
  setTimeout(() => {
    modal.style.display = 'none';
    content.style.transform = 'scale(1)';
    content.style.opacity = '1';
  }, 300);
}

function selecionarTodas() {
  const checkboxes = document.querySelectorAll('input[name="noticias_selecionadas[]"]');
  const todasSelecionadas = Array.from(checkboxes).every(cb => cb.checked);
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = !todasSelecionadas;
  });
  
  const botao = document.querySelector('[onclick="selecionarTodas()"]');
  if (todasSelecionadas) {
    botao.innerHTML = '<i class="fas fa-check-double me-2"></i>Selecionar Todas';
    showNotification('Todas as notícias foram desselecionadas.', 'info');
  } else {
    botao.innerHTML = '<i class="fas fa-times me-2"></i>Desselecionar Todas';
    showNotification(`${checkboxes.length} notícia(s) selecionada(s).`, 'success');
  }
}

function excluirNoticias() {
  const selecionados = document.querySelectorAll('input[name="noticias_selecionadas[]"]:checked');

  if (selecionados.length === 0) {
    showNotification('Por favor, selecione pelo menos uma notícia para excluir.', 'warning');
    return;
  }

  const confirmacao = confirm(`Tem certeza que deseja excluir ${selecionados.length} notícia(s)? Esta ação não pode ser desfeita.`);
  
  if (confirmacao) {
    const ids = Array.from(selecionados).map(input => input.value).join(',');
    document.getElementById('noticiasIds').value = ids;
    document.getElementById('formExcluir').submit();
  }
}

function showNotification(message, type = 'info') {
  const notification = document.createElement('div');
  notification.className = `notification notification-${type}`;
  notification.innerHTML = `
    <div class="notification-content">
      <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
      <span>${message}</span>
    </div>
  `;
  
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.style.transform = 'translateX(0)';
    notification.style.opacity = '1';
  }, 10);
  
  setTimeout(() => {
    notification.style.transform = 'translateX(100%)';
    notification.style.opacity = '0';
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 4000);
}

const input = document.getElementById('profileInput');
const img = document.getElementById('profilePic');

input.addEventListener('change', function () {
  if (this.files && this.files[0]) {
    img.style.opacity = '0.7';
    img.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
      img.style.opacity = '1';
      img.style.transform = 'scale(1)';
    }, 200);
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const infoCards = document.querySelectorAll('.info-card');
  infoCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-3px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0) scale(1)';
    });
  });
  
  const buttons = document.querySelectorAll('.btn');
  buttons.forEach(button => {
    button.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-2px)';
    });
    
    button.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
});

function fecharModalAlterarSenha() {
  const modal = document.getElementById('modalAlterarSenha');
  const content = document.querySelector('#modalAlterarSenha .modal-content-custom');
  
  content.style.transform = 'scale(0.9)';
  content.style.opacity = '0';
  
  setTimeout(() => {
    modal.style.display = 'none';
    content.style.transform = 'scale(1)';
    content.style.opacity = '1';
  }, 300);
}

function abrirModalEditarPerfil() {
  document.getElementById('modalEditarPerfil').style.display = 'flex';
  setTimeout(() => {
    document.querySelector('#modalEditarPerfil .modal-content-custom').style.transform = 'scale(1)';
    document.querySelector('#modalEditarPerfil .modal-content-custom').style.opacity = '1';
  }, 10);
}

function fecharModalEditarPerfil() {
  const modal = document.getElementById('modalEditarPerfil');
  const content = document.querySelector('#modalEditarPerfil .modal-content-custom');
  
  content.style.transform = 'scale(0.9)';
  content.style.opacity = '0';
  
  setTimeout(() => {
    modal.style.display = 'none';
    content.style.transform = 'scale(1)';
    content.style.opacity = '1';
  }, 300);
}

function abrirModalAlterarSenha() {
  document.getElementById('modalAlterarSenha').style.display = 'flex';
  setTimeout(() => {
    document.querySelector('#modalAlterarSenha .modal-content-custom').style.transform = 'scale(1)';
    document.querySelector('#modalAlterarSenha .modal-content-custom').style.opacity = '1';
  }, 10);
  
  const form = document.querySelector('#modalAlterarSenha form');
  form.addEventListener('submit', validarFormularioSenha);
}

function validarFormularioSenha(event) {
  const senhaAtual = document.getElementById('senha_atual').value;
  const novaSenha = document.getElementById('nova_senha').value;
  const confirmarSenha = document.getElementById('confirmar_senha').value;
  
  limparMensagensErro();
  
  let temErro = false;
  
  if (senhaAtual.length < 1) {
    mostrarErro('senha_atual', 'Senha atual é obrigatória');
    temErro = true;
  }
  
  if (novaSenha.length < 6) {
    mostrarErro('nova_senha', 'Nova senha deve ter pelo menos 6 caracteres');
    temErro = true;
  }
  
  if (confirmarSenha !== novaSenha) {
    mostrarErro('confirmar_senha', 'As senhas não coincidem');
    temErro = true;
  }
  
  if (temErro) {
    event.preventDefault();
  }
}

function mostrarErro(campoId, mensagem) {
  const campo = document.getElementById(campoId);
  const erroDiv = document.createElement('div');
  erroDiv.className = 'erro-mensagem';
  erroDiv.style.color = '#ff6b6b';
  erroDiv.style.fontSize = '0.8rem';
  erroDiv.style.marginTop = '0.25rem';
  erroDiv.textContent = mensagem;
  
  campo.parentNode.appendChild(erroDiv);
  campo.style.borderColor = '#ff6b6b';
}

function limparMensagensErro() {
  const erros = document.querySelectorAll('.erro-mensagem');
  erros.forEach(erro => erro.remove());
  
  const campos = document.querySelectorAll('#modalAlterarSenha input');
  campos.forEach(campo => {
    campo.style.borderColor = 'rgba(255, 255, 255, 0.2)';
  });
}
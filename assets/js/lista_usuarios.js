document.addEventListener('DOMContentLoaded', function() {
    initSearch();
    initTableHover();
    initToastNotifications();
});

function initSearch() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const table = document.getElementById('usuariosTable');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            
            if (isVisible) {
                row.style.display = '';
                row.style.animation = 'fadeInUp 0.3s ease-out';
            } else {
                row.style.display = 'none';
            }
        });

        updateResultsCount();
    });
}

function updateResultsCount() {
    const visibleRows = document.querySelectorAll('#usuariosTable tbody tr:not([style*="display: none"])');
    const totalRows = document.querySelectorAll('#usuariosTable tbody tr');
    const paginationInfo = document.querySelector('.pagination-info span');
    
    if (paginationInfo) {
        paginationInfo.textContent = `Mostrando ${visibleRows.length} de ${totalRows.length} usuários`;
    }
}

function initTableHover() {
    const tableRows = document.querySelectorAll('#usuariosTable tbody tr');
    
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}


function verUsuario(userId) {
    const row = document.querySelector(`tr[data-user-id="${userId}"]`) || 
                document.querySelector(`tr:has(button[onclick*="${userId}"])`);
    
    if (row) {
        const nome = row.querySelector('.user-name')?.textContent || 'Usuário';
        const email = row.querySelector('.user-email')?.textContent || 'N/A';
        const telefone = row.querySelector('.user-phone')?.textContent || 'N/A';
        const sexo = row.querySelector('.sexo-badge')?.textContent.trim() || 'N/A';
        const noticias = row.querySelector('.noticias-count')?.textContent.trim() || '0';
        const fotoElement = row.querySelector('.user-avatar img');
        const fotoSrc = fotoElement ? fotoElement.src : 'img/usuarioTeste.png';

        document.getElementById('modalUsuarioNome').textContent = nome;
        document.getElementById('modalUsuarioEmail').textContent = email;
        document.getElementById('modalUsuarioTelefone').textContent = telefone;
        document.getElementById('modalUsuarioSexo').textContent = sexo;
        document.getElementById('modalUsuarioNoticias').textContent = `${noticias} notícias publicadas`;
        document.getElementById('modalUsuarioFoto').src = fotoSrc;

        abrirModalUsuario();
    }
}

function editarUsuario(userId) {
    if (confirm('Deseja editar este usuário?')) {
        
        showToast('Funcionalidade de edição em desenvolvimento', 'info');
    }
}

function excluirUsuario(userId) {
    if (confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')) {
        const row = document.querySelector(`tr[data-user-id="${userId}"]`) || 
                    document.querySelector(`tr:has(button[onclick*="${userId}"])`);
        
        if (row) {
            row.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                row.remove();
                updateResultsCount();
                showToast('Usuário excluído com sucesso!', 'success');
            }, 300);
        }
    }
}


function abrirModalUsuario() {
    const modal = document.getElementById('modalUsuario');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            modal.querySelector('.close-modal-btn').focus();
        }, 100);
    }
}

function fecharModalUsuario() {
    const modal = document.getElementById('modalUsuario');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

document.addEventListener('click', function(event) {
    const modal = document.getElementById('modalUsuario');
    if (event.target === modal) {
        fecharModalUsuario();
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        fecharModalUsuario();
    }
});


function exportarUsuarios() {
    const table = document.getElementById('usuariosTable');
    const rows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
    
    if (rows.length === 0) {
        showToast('Nenhum usuário para exportar', 'warning');
        return;
    }

    let csvContent = "data:text/csv;charset=utf-8,";
    
    // Cabeçalho
    csvContent += "ID,Nome,Email,Telefone,Sexo,Notícias\n";
    
    rows.forEach(row => {
        const id = row.querySelector('.user-id')?.textContent.replace('#', '') || '';
        const nome = row.querySelector('.user-name')?.textContent || '';
        const email = row.querySelector('.user-email')?.textContent || '';
        const telefone = row.querySelector('.user-phone')?.textContent || '';
        const sexo = row.querySelector('.sexo-badge')?.textContent.trim() || '';
        const noticias = row.querySelector('.noticias-count')?.textContent.trim().replace(/\D/g, '') || '0';
        
        csvContent += `"${id}","${nome}","${email}","${telefone}","${sexo}","${noticias}"\n`;
    });
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `usuarios_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showToast('Lista de usuários exportada com sucesso!', 'success');
}


function initToastNotifications() {
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        `;
        document.body.appendChild(toastContainer);
    }
}

function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        background: white;
        border-radius: 8px;
        padding: 1rem 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-left: 4px solid;
        min-width: 300px;
        max-width: 400px;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
    `;

    const colors = {
        success: '#4caf50',
        error: '#f44336',
        warning: '#ff9800',
        info: '#2196f3'
    };

    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };

    toast.style.borderLeftColor = colors[type] || colors.info;

    toast.innerHTML = `
        <i class="${icons[type] || icons.info}" style="color: ${colors[type] || colors.info}; font-size: 1.2rem;"></i>
        <span style="flex: 1;">${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #999; font-size: 1.2rem;">&times;</button>
    `;

    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300);
        }
    }, 5000);
}


if (!document.querySelector('#fadeOutAnimation')) {
    const style = document.createElement('style');
    style.id = 'fadeOutAnimation';
    style.textContent = `
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }
            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }
    `;
    document.head.appendChild(style);
}


function sortTable(columnIndex) {
    const table = document.getElementById('usuariosTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        if (!isNaN(aValue) && !isNaN(bValue)) {
            return parseInt(aValue) - parseInt(bValue);
        }
        
        return aValue.localeCompare(bValue);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#usuariosTable tbody tr');
    rows.forEach((row, index) => {
        const userId = row.querySelector('.user-id')?.textContent.replace('#', '') || (index + 1);
        row.setAttribute('data-user-id', userId);
    });
});


document.addEventListener('keydown', function(event) {
    const activeElement = document.activeElement;
    
    if (activeElement && activeElement.closest('#usuariosTable')) {
        const currentRow = activeElement.closest('tr');
        const rows = Array.from(document.querySelectorAll('#usuariosTable tbody tr'));
        const currentIndex = rows.indexOf(currentRow);
        
        switch(event.key) {
            case 'ArrowDown':
                event.preventDefault();
                if (currentIndex < rows.length - 1) {
                    rows[currentIndex + 1].focus();
                }
                break;
            case 'ArrowUp':
                event.preventDefault();
                if (currentIndex > 0) {
                    rows[currentIndex - 1].focus();
                }
                break;
            case 'Enter':
                event.preventDefault();
                const viewButton = currentRow.querySelector('.btn-view');
                if (viewButton) {
                    viewButton.click();
                }
                break;
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#usuariosTable tbody tr');
    rows.forEach(row => {
        row.setAttribute('tabindex', '0');
        row.setAttribute('role', 'button');
        row.setAttribute('aria-label', `Ver detalhes do usuário ${row.querySelector('.user-name')?.textContent || ''}`);
    });
});

function abrirModalEditarUsuario(userId) {
    const row = document.querySelector(`tr[data-user-id="${userId}"]`);
    if (!row) return;
    document.getElementById('editUsuarioId').value = userId;
    document.getElementById('editNome').value = row.querySelector('.user-name')?.textContent.trim() || '';
    document.getElementById('editEmail').value = row.querySelector('.user-email')?.textContent.trim() || '';
    document.getElementById('editFone').value = row.querySelector('.user-phone')?.textContent.trim() || '';
    const sexo = row.querySelector('.sexo-badge')?.textContent.trim().toLowerCase();
    if (sexo && sexo.includes('masculino')) document.getElementById('editSexo').value = 'M';
    else if (sexo && sexo.includes('feminino')) document.getElementById('editSexo').value = 'F';
    else document.getElementById('editSexo').value = 'O';
    const tipo = row.querySelector('.user-role')?.textContent.trim().toLowerCase();
    if (tipo && tipo.includes('admin')) document.getElementById('editTipo').value = 'admin';
    else if (tipo && tipo.includes('autor')) document.getElementById('editTipo').value = 'autor';
    else document.getElementById('editTipo').value = 'usuario';
    document.getElementById('modalEditarUsuario').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function fecharModalEditarUsuario() {
    document.getElementById('modalEditarUsuario').style.display = 'none';
    document.body.style.overflow = '';
} 
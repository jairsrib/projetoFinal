function abrirModalCadastrar() {
  document.getElementById('modalNoticia').style.display = 'flex';
}

function fecharModalCadastrar() {
  document.getElementById('modalNoticia').style.display = 'none';
}


function abrirModalEditar() {
  const selecionados = document.querySelectorAll('input[name="noticias_selecionadas[]"]:checked');

  if (selecionados.length !== 1) {
    alert("Selecione exatamente uma notícia para editar.");
    return;
  }

  const noticia = selecionados[0];
  
  document.getElementById('modalEditar').style.display = 'flex';
  document.getElementById('idsNoticiasSelecionadas').value = noticia.value;
  document.getElementById('titulo').value = noticia.dataset.titulo || '';
  document.getElementById('texto').value = noticia.dataset.texto || '';
  
  const selectCategoria = document.querySelector('#modalEditar select[name="categoria"]');
  selectCategoria.value = noticia.dataset.categoria.toString(); 
}



function fecharModalEditar() {
  document.getElementById('modalEditar').style.display = 'none';
}

const input = document.getElementById('profileInput');
const img = document.getElementById('profilePic');
input.addEventListener('change', function () {
  if (this.files && this.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      img.src = e.target.result;
    }
    reader.readAsDataURL(this.files[0]);
  }
});
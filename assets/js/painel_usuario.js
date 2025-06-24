function abrirModalCadastrar() {
  document.getElementById('modalNoticia').style.display = 'flex';
}

function fecharModalCadastrar() {
  document.getElementById('modalNoticia').style.display = 'none';
}

function abrirModalEditar() {
  // Abre o modal
  document.getElementById('modalEditar').style.display = 'flex';
  const selecionados = document.querySelectorAll('input[name="noticias_selecionadas[]"]:checked');

  if (selecionados.length !== 1) {
    alert("Selecione exatamente uma notícia para editar.");
    return;
  }
  document.getElementById('id_noticia').value = noticia.value;

  const noticia = selecionados[0];

  // Preenche os campos do modal com os dados da notícia
  document.getElementById('email').value = noticia.dataset.titulo;
  document.getElementById('textarea').value = noticia.dataset.texto;

  const categoriaSelect = document.querySelector('select[name="categoria"]');
  categoriaSelect.value = noticia.dataset.categoria;

  
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
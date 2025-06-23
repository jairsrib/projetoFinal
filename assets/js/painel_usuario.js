 function abrirModal() {
    document.getElementById('modalNoticia').style.display = 'flex';
  }

  function fecharModal() {
    document.getElementById('modalNoticia').style.display = 'none';
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
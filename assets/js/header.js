function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const btnHamburger = document.getElementById("btn-hamburguer");
  
  sidebar.classList.toggle("active");
  overlay.classList.toggle("active");
  
  btnHamburger.classList.toggle("active");
  
  if (sidebar.classList.contains("active")) {
    document.body.style.overflow = "hidden";
  } else {
    document.body.style.overflow = "auto";
  }
}

function updateDateTime() {
  const now = new Date();
  
  const diasSemana = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
  
  const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
  
  const diaElement = document.querySelector('.card-time-cloud-day');
  const dataElement = document.querySelector('.card-time-cloud-day-number');
  const horaElement = document.querySelector('.card-time-cloud-hour');
  
  if (diaElement && dataElement && horaElement) {
    diaElement.textContent = diasSemana[now.getDay()];
    
    const dia = now.getDate().toString().padStart(2, '0');
    const mes = (now.getMonth() + 1).toString().padStart(2, '0');
    const ano = now.getFullYear();
    dataElement.textContent = `${dia}/${mes}/${ano}`;
    
    const hora = now.getHours().toString().padStart(2, '0');
    const minuto = now.getMinutes().toString().padStart(2, '0');
    horaElement.textContent = `${hora}:${minuto}`;
  }
}

updateDateTime();

setInterval(updateDateTime, 60000);

document.addEventListener('DOMContentLoaded', function() {
  const overlay = document.getElementById("overlay");
  const sidebar = document.getElementById("sidebar");
  
  overlay.addEventListener('click', function() {
    toggleSidebar();
  });
  
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && sidebar.classList.contains("active")) {
      toggleSidebar();
    }
  });
  
  marcarPaginaAtual();
  
  adicionarEfeitosHover();
});

function marcarPaginaAtual() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.php';
  const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
  
  sidebarLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage || (currentPage === '' && href === 'index.php')) {
      link.classList.add('active');
    }
  });
}

function adicionarEfeitosHover() {
  const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
  
  sidebarLinks.forEach(link => {
    link.addEventListener('mouseenter', function() {
      this.style.transform = 'translateX(5px)';
    });
    
    link.addEventListener('mouseleave', function() {
      this.style.transform = 'translateX(0)';
    });
    
    link.addEventListener('click', function() {
      this.style.transform = 'translateX(2px)';
      setTimeout(() => {
        this.style.transform = 'translateX(0)';
      }, 150);
    });
  });
}

function fecharSidebarAposClique() {
  const sidebar = document.getElementById("sidebar");
  const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
  
  sidebarLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 768) {
        setTimeout(() => {
          toggleSidebar();
        }, 300);
      }
    });
  });
}

lucide.createIcons();

document.addEventListener('DOMContentLoaded', fecharSidebarAposClique);
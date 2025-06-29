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
  const currentPage = window.location.pathname.split('/').pop() || 'dashboard.php';
  const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
  
  sidebarLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage || (currentPage === '' && href === 'dashboard.php')) {
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
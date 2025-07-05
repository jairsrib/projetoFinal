function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("overlay");
  const btnHamburger = document.getElementById("btn-hamburguer");
  
  sidebar.classList.toggle("show");
  overlay.classList.toggle("active");
  
  btnHamburger.classList.toggle("active");
  
  if (sidebar.classList.contains("show")) {
    document.body.style.overflow = "hidden";
    sidebar.style.transform = "translateX(0)";
  } else {
    document.body.style.overflow = "auto";
    sidebar.style.transform = "translateX(-100%)";
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const overlay = document.getElementById("overlay");
  const sidebar = document.getElementById("sidebar");
  const btnHamburger = document.getElementById("btn-hamburguer");
  
  overlay.addEventListener('click', function() {
    toggleSidebar();
  });
  
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && sidebar.classList.contains("show")) {
      toggleSidebar();
    }
  });
  
  marcarPaginaAtual();
  
  adicionarEfeitosHover();
  
  adicionarAnimacoesHeader();
  
  fecharSidebarAposClique();
  
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
});

function marcarPaginaAtual() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.php';
  const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
  
  sidebarLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage || (currentPage === '' && href === 'index.php')) {
      link.classList.add('active');
      link.style.borderLeftColor = '#ff6b9d';
      link.style.background = 'rgba(255, 107, 157, 0.1)';
    }
  });
}

function adicionarEfeitosHover() {
  const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
  const btnHamburger = document.getElementById("btn-hamburguer");
  
  sidebarLinks.forEach(link => {
    link.addEventListener('mouseenter', function() {
      this.style.transform = 'translateX(8px)';
      this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    });
    
    link.addEventListener('mouseleave', function() {
      this.style.transform = 'translateX(0)';
    });
    
    link.addEventListener('click', function() {
      this.style.transform = 'translateX(4px) scale(0.98)';
      setTimeout(() => {
        this.style.transform = 'translateX(0) scale(1)';
      }, 200);
    });
  });
  
  if (btnHamburger) {
    btnHamburger.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-2px) scale(1.05)';
    });
    
    btnHamburger.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0) scale(1)';
    });
    
    btnHamburger.addEventListener('click', function() {
      this.style.transform = 'translateY(0) scale(0.95)';
      setTimeout(() => {
        this.style.transform = 'translateY(0) scale(1)';
      }, 150);
    });
  }
}

function adicionarAnimacoesHeader() {
  const header = document.querySelector('header');
  const logo = document.querySelector('.logo');
  const previsaoTempo = document.querySelector('.previsao-do-tempo');
  
  if (header) {
    header.style.opacity = '0';
    header.style.transform = 'translateY(-20px)';
    
    setTimeout(() => {
      header.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
      header.style.opacity = '1';
      header.style.transform = 'translateY(0)';
    }, 100);
  }
  
  if (logo) {
    logo.style.opacity = '0';
    logo.style.transform = 'translateX(-20px)';
    
    setTimeout(() => {
      logo.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
      logo.style.opacity = '1';
      logo.style.transform = 'translateX(0)';
    }, 200);
  }
  
  if (previsaoTempo) {
    previsaoTempo.style.opacity = '0';
    previsaoTempo.style.transform = 'translateX(20px)';
    
    setTimeout(() => {
      previsaoTempo.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
      previsaoTempo.style.opacity = '1';
      previsaoTempo.style.transform = 'translateX(0)';
    }, 300);
  }
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

function melhorarResponsividade() {
  const header = document.querySelector('header');
  const container = document.querySelector('.container');
  
  function ajustarLayout() {
    if (window.innerWidth <= 600) {
      if (container) {
        container.style.padding = '0 0.8rem';
      }
    } else if (window.innerWidth <= 900) {
      if (container) {
        container.style.padding = '0 1rem';
      }
    } else {
      if (container) {
        container.style.padding = '0 2rem';
      }
    }
  }
  
  ajustarLayout();
  
  window.addEventListener('resize', ajustarLayout);
}

function adicionarEfeitosScroll() {
  const header = document.querySelector('header');
  let lastScrollTop = 0;
  
  window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > lastScrollTop && scrollTop > 100) {
      header.style.transform = 'translateY(-100%)';
    } else {
      header.style.transform = 'translateY(0)';
    }
    
    lastScrollTop = scrollTop;
  });
}

function melhorarAcessibilidade() {
  const btnHamburger = document.getElementById("btn-hamburguer");
  const sidebarLinks = document.querySelectorAll('.sidebar ul li a');
  
  if (btnHamburger) {
    btnHamburger.addEventListener('keydown', function(event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        toggleSidebar();
      }
    });
  }
  
  sidebarLinks.forEach(link => {
    link.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        this.click();
      }
    });
  });
}

document.addEventListener('DOMContentLoaded', function() {
  melhorarResponsividade();
  adicionarEfeitosScroll();
  melhorarAcessibilidade();
});

if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const style = document.createElement('style');
  style.textContent = `
    * {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
    }
  `;
  document.head.appendChild(style);
}
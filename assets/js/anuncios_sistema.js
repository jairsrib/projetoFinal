/**
 * Sistema de Anúncios - Controle de Pop-up e Carrossel Lateral
 * Gerencia a exibição de anúncios por prioridade
 */

class AnunciosSistema {
    constructor() {
        this.anuncioPopupData = null;
        this.anunciosCarrosselData = [];
        this.carrosselIndex = 0;
        this.carrosselInterval = null;
        this.anunciosFechados = new Set();
        this.init();
    }

    init() {
        // Aguardar o DOM estar pronto
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        // Inicializar popup se houver dados
        if (window.anuncioPopupData) {
            this.anuncioPopupData = window.anuncioPopupData;
            this.mostrarAnuncioPopup();
        }

        // Inicializar carrossel se houver dados
        if (window.anunciosCarrosselData && window.anunciosCarrosselData.length > 0) {
            this.anunciosCarrosselData = window.anunciosCarrosselData;
            this.inicializarCarrossel();
        }

        // Configurar eventos
        this.configurarEventos();
    }

    mostrarAnuncioPopup() {
        if (!this.anuncioPopupData) return;
        
        // Verificar se já foi fechado nesta sessão
        if (localStorage.getItem('anuncio_popup_fechado') === 'true') return;
        
        const popup = document.getElementById('anuncio-popup');
        if (popup) {
            // Delay aleatório entre 2 e 5 segundos
            const delay = Math.random() * 3000 + 2000;
            
            setTimeout(() => {
                popup.style.display = 'flex';
                popup.classList.add('show');
            }, delay);
        }
    }

    fecharAnuncioPopup() {
        const popup = document.getElementById('anuncio-popup');
        if (popup) {
            popup.style.display = 'none';
            popup.classList.remove('show');
            // Salvar no localStorage para não mostrar novamente na sessão
            localStorage.setItem('anuncio_popup_fechado', 'true');
        }
    }

    inicializarCarrossel() {
        if (this.anunciosCarrosselData.length === 0) return;
        
        this.mostrarAnuncioCarrossel(0);
        
        // Iniciar alternância automática a cada 5 segundos
        this.carrosselInterval = setInterval(() => {
            this.alternarAnunciosCarrossel();
        }, 5000);
    }

    mostrarAnuncioCarrossel(index) {
        if (this.anunciosCarrosselData.length === 0) return;
        
        // Esconder todos os anúncios
        const items = document.querySelectorAll('.anuncio-carrossel-item');
        const indicadores = document.querySelectorAll('.anuncio-indicador');
        
        items.forEach(item => item.classList.remove('ativo'));
        indicadores.forEach(ind => ind.classList.remove('ativo'));
        
        // Mostrar o anúncio selecionado
        if (items[index]) {
            items[index].classList.add('ativo');
        }
        if (indicadores[index]) {
            indicadores[index].classList.add('ativo');
        }
        
        this.carrosselIndex = index;
    }

    fecharAnuncioCarrossel(index) {
        this.anunciosFechados.add(index);
        
        // Se todos os anúncios foram fechados, esconder o carrossel
        if (this.anunciosFechados.size >= this.anunciosCarrosselData.length) {
            const carrossel = document.getElementById('anuncios-carrossel');
            if (carrossel) {
                carrossel.style.display = 'none';
            }
            return;
        }
        
        // Encontrar próximo anúncio disponível
        let proximoIndex = (index + 1) % this.anunciosCarrosselData.length;
        while (this.anunciosFechados.has(proximoIndex)) {
            proximoIndex = (proximoIndex + 1) % this.anunciosCarrosselData.length;
        }
        
        this.mostrarAnuncioCarrossel(proximoIndex);
    }

    alternarAnunciosCarrossel() {
        if (this.anunciosCarrosselData.length === 0) return;
        
        // Encontrar próximo anúncio não fechado
        let proximoIndex = (this.carrosselIndex + 1) % this.anunciosCarrosselData.length;
        while (this.anunciosFechados.has(proximoIndex)) {
            proximoIndex = (proximoIndex + 1) % this.anunciosCarrosselData.length;
        }
        
        // Se todos foram fechados, parar o intervalo
        if (this.anunciosFechados.size >= this.anunciosCarrosselData.length) {
            clearInterval(this.carrosselInterval);
            return;
        }
        
        this.mostrarAnuncioCarrossel(proximoIndex);
    }

    configurarEventos() {
        // Fechar popup ao clicar fora dele
        document.addEventListener('click', (e) => {
            const popup = document.getElementById('anuncio-popup');
            if (popup && e.target === popup) {
                this.fecharAnuncioPopup();
            }
        });

        // Pausar carrossel quando o mouse estiver sobre ele
        document.addEventListener('mouseenter', (e) => {
            if (e.target.closest('.anuncios-carrossel')) {
                clearInterval(this.carrosselInterval);
            }
        });

        // Retomar carrossel quando o mouse sair
        document.addEventListener('mouseleave', (e) => {
            if (e.target.closest('.anuncios-carrossel')) {
                this.carrosselInterval = setInterval(() => {
                    this.alternarAnunciosCarrossel();
                }, 5000);
            }
        });

        // Configurar eventos de teclado
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.fecharAnuncioPopup();
            }
        });
    }

    // Métodos públicos para uso externo
    getAnuncioPopupData() {
        return this.anuncioPopupData;
    }

    getAnunciosCarrosselData() {
        return this.anunciosCarrosselData;
    }

    getCarrosselIndex() {
        return this.carrosselIndex;
    }

    isCarrosselAtivo() {
        return this.carrosselInterval !== null;
    }
}

// Funções globais para compatibilidade com o HTML
function fecharAnuncioPopup() {
    if (window.anunciosSistema) {
        window.anunciosSistema.fecharAnuncioPopup();
    }
}

function mostrarAnuncioCarrossel(index) {
    if (window.anunciosSistema) {
        window.anunciosSistema.mostrarAnuncioCarrossel(index);
    }
}

function fecharAnuncioCarrossel(index) {
    if (window.anunciosSistema) {
        window.anunciosSistema.fecharAnuncioCarrossel(index);
    }
}

// Inicializar o sistema quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.anunciosSistema = new AnunciosSistema();
});

// Exportar para uso em outros módulos
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AnunciosSistema;
} 
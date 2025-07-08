<?php
require_once 'classes/AnuncioManager.php';

$anuncioManager = new AnuncioManager();

// Buscar anúncios de prioridade alta para pop-up
$anuncioPopup = $anuncioManager->getAnuncioPrioridadeAltaAleatorio();

// Buscar anúncios de outras prioridades para carrossel lateral
$anunciosCarrossel = $anuncioManager->getAnunciosOutrasPrioridades();

// Função para formatar data
function formatarData($dataString) {
    $data = new DateTime($dataString);
    return $data->format('d/m/Y H:i');
}

// Função para obter classe CSS baseada na categoria
function getCategoriaClass($categoria) {
    $classes = [
        'lançamento' => 'categoria-lancamento',
        'promoção' => 'categoria-promocao',
        'evento' => 'categoria-evento',
        'sistema' => 'categoria-sistema',
        'comunidade' => 'categoria-comunidade'
    ];
    
    return $classes[$categoria] ?? 'categoria-geral';
}
?>

<!-- Sistema de Anúncios - Pop-up para Prioridade Alta -->
<?php if ($anuncioPopup): ?>
<div id="anuncio-popup" class="anuncio-popup-overlay">
    <div class="anuncio-popup-container">
        <div class="anuncio-popup-header">
            <h3>🎉 Anúncio Importante!</h3>
            <button class="anuncio-popup-close" onclick="fecharAnuncioPopup()">
                <i data-lucide="x"></i>
            </button>
        </div>
        
        <div class="anuncio-popup-content">
            <?php if (!empty($anuncioPopup['imagem'])): ?>
                <div class="anuncio-popup-imagem">
                    <img src="<?php echo (strpos($anuncioPopup['imagem'], 'uploads/') === 0 ? '' : 'uploads/anuncios/') . htmlspecialchars($anuncioPopup['imagem']); ?>" 
                         alt="<?php echo htmlspecialchars($anuncioPopup['nome'] ?? ''); ?>"
                         onerror="this.style.display='none'">
                </div>
            <?php endif; ?>
            
            <div class="anuncio-popup-texto">
                <h4><?php echo htmlspecialchars($anuncioPopup['nome'] ?? ''); ?></h4>
                <p><?php echo htmlspecialchars($anuncioPopup['texto'] ?? ''); ?></p>
                
                <?php if (!empty($anuncioPopup['link'])): ?>
                    <a href="<?php echo htmlspecialchars($anuncioPopup['link']); ?>" 
                       class="anuncio-popup-link" 
                       target="_blank" 
                       rel="noopener noreferrer">
                        Aproveitar Agora!
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="anuncio-popup-footer">
            <button class="anuncio-popup-close-btn" onclick="fecharAnuncioPopup()">
                Fechar
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Sistema de Anúncios - Carrossel Lateral -->
<?php if (!empty($anunciosCarrossel)): ?>
<div id="anuncios-carrossel" class="anuncios-carrossel">
    <div class="anuncios-carrossel-container">
        <?php foreach ($anunciosCarrossel as $index => $anuncio): ?>
            <div class="anuncio-carrossel-item <?php echo $index === 0 ? 'ativo' : ''; ?>" 
                 data-index="<?php echo $index; ?>">
                <div class="anuncio-carrossel-content">
                    <?php if (!empty($anuncio['imagem'])): ?>
                        <div class="anuncio-carrossel-imagem">
                            <img src="<?php echo (strpos($anuncio['imagem'], 'uploads/') === 0 ? '' : 'uploads/anuncios/') . htmlspecialchars($anuncio['imagem']); ?>"
                                 alt="<?php echo htmlspecialchars($anuncio['nome'] ?? ''); ?>"
                                 onerror="this.style.display='none'">
                        </div>
                    <?php endif; ?>
                    
                    <div class="anuncio-carrossel-texto">
                        <h5><?php echo htmlspecialchars($anuncio['nome'] ?? ''); ?></h5>
                        <p><?php echo htmlspecialchars($anuncio['texto'] ?? ''); ?></p>
                        
                        <?php if (!empty($anuncio['link'])): ?>
                            <a href="<?php echo htmlspecialchars($anuncio['link']); ?>" 
                               class="anuncio-carrossel-link" 
                               target="_blank" 
                               rel="noopener noreferrer">
                                Ver Mais
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <button class="anuncio-carrossel-close" onclick="fecharAnuncioCarrossel(<?php echo $index; ?>)">
                    <i data-lucide="x"></i>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Indicadores do carrossel -->
    <div class="anuncios-carrossel-indicadores">
        <?php foreach ($anunciosCarrossel as $index => $anuncio): ?>
            <button class="anuncio-indicador <?php echo $index === 0 ? 'ativo' : ''; ?>" 
                    onclick="mostrarAnuncioCarrossel(<?php echo $index; ?>)">
                <span class="anuncio-indicador-dot"></span>
            </button>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<style>
/* Estilos para o Pop-up de Anúncios de Prioridade Alta */
.anuncio-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 10000;
    backdrop-filter: blur(8px);
}

.anuncio-popup-container {
    background: var(--card-bg);
    border-radius: 20px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: popupSlideIn 0.4s ease-out;
}

@keyframes popupSlideIn {
    from {
        opacity: 0;
        transform: scale(0.8) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.anuncio-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem 1rem;
    border-bottom: 1px solid var(--border-color);
}

.anuncio-popup-header h3 {
    margin: 0;
    color: var(--text-color);
    font-size: 1.3rem;
    font-weight: 600;
}

.anuncio-popup-close {
    background: none;
    border: none;
    color: var(--text-color);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: background 0.2s;
}

.anuncio-popup-close:hover {
    background: var(--hover-bg);
}

.anuncio-popup-content {
    padding: 1.5rem 2rem;
}

.anuncio-popup-imagem {
    margin-bottom: 1rem;
    border-radius: 12px;
    overflow: hidden;
}

.anuncio-popup-imagem img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.anuncio-popup-texto h4 {
    margin: 0 0 0.5rem 0;
    color: var(--text-color);
    font-size: 1.2rem;
    font-weight: 600;
}

.anuncio-popup-texto p {
    margin: 0 0 1rem 0;
    color: var(--text-secondary);
    line-height: 1.5;
}

.anuncio-popup-link {
    display: inline-block;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: transform 0.2s, box-shadow 0.2s;
}

.anuncio-popup-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(var(--primary-color-rgb), 0.4);
}

.anuncio-popup-footer {
    padding: 1rem 2rem 1.5rem;
    text-align: center;
}

.anuncio-popup-close-btn {
    background: var(--card-bg);
    border: 2px solid var(--border-color);
    color: var(--text-color);
    padding: 0.6rem 1.2rem;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
}

.anuncio-popup-close-btn:hover {
    background: var(--hover-bg);
    border-color: var(--primary-color);
}

/* Estilos para o Carrossel Lateral */
.anuncios-carrossel {
    position: fixed;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    width: 300px;
    max-height: 400px;
    z-index: 9999;
}

.anuncios-carrossel-container {
    position: relative;
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.anuncio-carrossel-item {
    display: none;
    padding: 1rem;
    animation: carrosselSlideIn 0.5s ease-out;
}

.anuncio-carrossel-item.ativo {
    display: block;
}

@keyframes carrosselSlideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.anuncio-carrossel-content {
    position: relative;
}

.anuncio-carrossel-imagem {
    margin-bottom: 0.8rem;
    border-radius: 8px;
    overflow: hidden;
}

.anuncio-carrossel-imagem img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.anuncio-carrossel-texto h5 {
    margin: 0 0 0.5rem 0;
    color: var(--text-color);
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.3;
}

.anuncio-carrossel-texto p {
    margin: 0 0 0.8rem 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.4;
}

.anuncio-carrossel-link {
    display: inline-block;
    background: var(--primary-color);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    transition: background 0.2s;
}

.anuncio-carrossel-link:hover {
    background: var(--secondary-color);
}

.anuncio-carrossel-close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(0, 0, 0, 0.5);
    border: none;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: background 0.2s;
}

.anuncio-carrossel-close:hover {
    background: rgba(0, 0, 0, 0.7);
}

.anuncios-carrossel-indicadores {
    display: flex;
    justify-content: center;
    gap: 0.3rem;
    margin-top: 0.8rem;
}

.anuncio-indicador {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.2rem;
}

.anuncio-indicador-dot {
    display: block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--border-color);
    transition: background 0.3s;
}

.anuncio-indicador.ativo .anuncio-indicador-dot {
    background: var(--primary-color);
}

/* Responsividade */
@media (max-width: 768px) {
    .anuncios-carrossel {
        right: 10px;
        width: 250px;
        max-height: 350px;
    }
    
    .anuncio-popup-container {
        width: 95%;
        max-width: 400px;
    }
    
    .anuncio-popup-header,
    .anuncio-popup-content,
    .anuncio-popup-footer {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (max-width: 480px) {
    .anuncios-carrossel {
        right: 5px;
        width: 200px;
        max-height: 300px;
    }
    
    .anuncio-carrossel-texto h5 {
        font-size: 0.9rem;
    }
    
    .anuncio-carrossel-texto p {
        font-size: 0.8rem;
    }
}
</style>

<script>
// Dados dos anúncios para JavaScript
const anuncioPopupData = <?php echo $anuncioPopup ? json_encode($anuncioPopup) : 'null'; ?>;
const anunciosCarrosselData = <?php echo !empty($anunciosCarrossel) ? json_encode($anunciosCarrossel) : '[]'; ?>;

// Variáveis para controle do carrossel
let carrosselIndex = 0;
let carrosselInterval;
let anunciosFechados = new Set();

// Função para fechar o popup de prioridade alta
function fecharAnuncioPopup() {
    const popup = document.getElementById('anuncio-popup');
    if (popup) {
        popup.style.display = 'none';
        // Salvar no localStorage para não mostrar novamente na sessão
        localStorage.setItem('anuncio_popup_fechado', 'true');
    }
}

// Função para mostrar o popup com delay
function mostrarAnuncioPopup() {
    if (!anuncioPopupData) return;
    
    // Verificar se já foi fechado nesta sessão
    if (localStorage.getItem('anuncio_popup_fechado') === 'true') return;
    
    const popup = document.getElementById('anuncio-popup');
    if (popup) {
        // Delay aleatório entre 2 e 5 segundos
        const delay = Math.random() * 3000 + 2000;
        
        setTimeout(() => {
            popup.style.display = 'flex';
        }, delay);
    }
}

// Função para mostrar anúncio específico no carrossel
function mostrarAnuncioCarrossel(index) {
    if (anunciosCarrosselData.length === 0) return;
    
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
    
    carrosselIndex = index;
}

// Função para fechar anúncio específico do carrossel
function fecharAnuncioCarrossel(index) {
    anunciosFechados.add(index);
    
    // Se todos os anúncios foram fechados, esconder o carrossel
    if (anunciosFechados.size >= anunciosCarrosselData.length) {
        const carrossel = document.getElementById('anuncios-carrossel');
        if (carrossel) {
            carrossel.style.display = 'none';
        }
        return;
    }
    
    // Encontrar próximo anúncio disponível
    let proximoIndex = (index + 1) % anunciosCarrosselData.length;
    while (anunciosFechados.has(proximoIndex)) {
        proximoIndex = (proximoIndex + 1) % anunciosCarrosselData.length;
    }
    
    mostrarAnuncioCarrossel(proximoIndex);
}

// Função para alternar anúncios automaticamente
function alternarAnunciosCarrossel() {
    if (anunciosCarrosselData.length === 0) return;
    
    // Encontrar próximo anúncio não fechado
    let proximoIndex = (carrosselIndex + 1) % anunciosCarrosselData.length;
    while (anunciosFechados.has(proximoIndex)) {
        proximoIndex = (proximoIndex + 1) % anunciosCarrosselData.length;
    }
    
    // Se todos foram fechados, parar o intervalo
    if (anunciosFechados.size >= anunciosCarrosselData.length) {
        clearInterval(carrosselInterval);
        return;
    }
    
    mostrarAnuncioCarrossel(proximoIndex);
}

// Inicializar sistema de anúncios
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar popup
    mostrarAnuncioPopup();
    
    // Inicializar carrossel se houver anúncios
    if (anunciosCarrosselData.length > 0) {
        mostrarAnuncioCarrossel(0);
        
        // Iniciar alternância automática a cada 5 segundos
        carrosselInterval = setInterval(alternarAnunciosCarrossel, 5000);
    }
});

// Fechar popup ao clicar fora dele
document.addEventListener('click', function(e) {
    const popup = document.getElementById('anuncio-popup');
    if (popup && e.target === popup) {
        fecharAnuncioPopup();
    }
});

// Pausar carrossel quando o mouse estiver sobre ele
document.addEventListener('mouseenter', function(e) {
    if (e.target.closest('.anuncios-carrossel')) {
        clearInterval(carrosselInterval);
    }
});

// Retomar carrossel quando o mouse sair
document.addEventListener('mouseleave', function(e) {
    if (e.target.closest('.anuncios-carrossel')) {
        carrosselInterval = setInterval(alternarAnunciosCarrossel, 5000);
    }
});
</script> 
<?php
require_once 'classes/AnuncioManager.php';

$anuncioManager = new AnuncioManager();

// Buscar anúncios ativos para exibição
$anunciosAtivos = $anuncioManager->getAnunciosAtivos();

// Buscar anúncio aleatório para popup
$anuncioPopup = $anuncioManager->getAnuncioAleatorio();

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

<!-- Seção de Anúncios -->
<div class="anuncios-container">
    <h2 class="anuncios-titulo">Anúncios e Promoções</h2>
    <!-- Grid responsivo de anúncios -->
    <div id="anuncios" class="anuncios-grid">
        <?php if (empty($anunciosAtivos)): ?>
            <div class="anuncio-vazio">
                <p>Nenhum anúncio ativo no momento.</p>
            </div>
        <?php else: ?>
            <?php foreach ($anunciosAtivos as $anuncio): ?>
                <!-- Card responsivo de anúncio -->
                <div class="anuncio-card <?php echo !empty($anuncio['destaque']) ? 'anuncio-destaque' : ''; ?>" data-id="<?php echo $anuncio['id'] ?? ''; ?>">
                    <?php if (!empty($anuncio['destaque'])): ?>
                        <div class="anuncio-badge-destaque">⭐ Destaque</div>
                    <?php endif; ?>
                    <div class="anuncio-conteudo">
                        <?php if (!empty($anuncio['imagem'])): ?>
                            <div class="anuncio-imagem">
                                <!-- Imagem responsiva -->
                                <img src="<?php echo (strpos($anuncio['imagem'], 'uploads/') === 0 ? '' : 'uploads/anuncios/') . htmlspecialchars($anuncio['imagem']); ?>"
                                     alt="<?php echo htmlspecialchars($anuncio['nome'] ?? ''); ?>"
                                     onerror="this.style.display='none'">
                            </div>
                        <?php endif; ?>
                        <div class="anuncio-texto">
                            <h3 class="anuncio-titulo"><?php echo htmlspecialchars($anuncio['nome'] ?? ''); ?></h3>
                            <p class="anuncio-descricao"><?php echo htmlspecialchars($anuncio['texto'] ?? ''); ?></p>
                            <div class="anuncio-meta">
                                <span class="anuncio-data">
                                    <i class="icon-calendar"></i>
                                    <?php echo isset($anuncio['data_cadastro']) ? formatarData($anuncio['data_cadastro']) : ''; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($anuncio['link'])): ?>
                        <div class="anuncio-acoes">
                            <a href="<?php echo htmlspecialchars($anuncio['link']); ?>"
                               class="anuncio-link"
                               target="_blank"
                               rel="noopener noreferrer">
                                <span>Ver Mais</span>
                                <i class="icon-external-link"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Popup para Anúncio Promocional -->
<?php if ($anuncioPopup): ?>
<div id="anuncio-popup" class="anuncio-popup-overlay">
    <div class="anuncio-popup">
        <div class="anuncio-popup-header">
            <h3>🎉 Promoção Especial!</h3>
            <button class="anuncio-popup-close" onclick="fecharAnuncioPopup()">
                <i class="icon-close"></i>
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

<script>
// Dados do anúncio popup para JavaScript
const anuncioPopupData = <?php echo $anuncioPopup ? json_encode($anuncioPopup) : 'null'; ?>;

// Função para fechar o popup
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
            popup.classList.add('anuncio-popup-show');
        }, delay);
    }
}

// Inicializar popup quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    mostrarAnuncioPopup();
});

// Fechar popup ao clicar fora dele
document.addEventListener('click', function(e) {
    const popup = document.getElementById('anuncio-popup');
    if (popup && e.target === popup) {
        fecharAnuncioPopup();
    }
});
</script> 
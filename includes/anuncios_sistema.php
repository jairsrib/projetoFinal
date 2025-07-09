<?php
require_once 'classes/AnuncioManager.php';

$anuncioManager = new AnuncioManager();
$anunciosNaoExpirados = $anuncioManager->getAnunciosNaoExpirados();

echo "<!-- JSON usado: " . realpath(__DIR__ . '/../data/anuncios.json') . " -->";
echo "<!-- Anúncios não expirados encontrados: " . count($anunciosNaoExpirados) . " -->";
?>

<?php if (!empty($anunciosNaoExpirados)): ?>
<div id="anuncios-carrossel-lateral" class="anuncios-carrossel-lateral">
    <div class="anuncios-carrossel-lateral-container">
        <?php foreach ($anunciosNaoExpirados as $index => $anuncio): ?>
            <div class="anuncio-carrossel-lateral-item <?php echo $index === 0 ? 'ativo' : ''; ?>" data-index="<?php echo $index; ?>">
                <div class="anuncio-carrossel-lateral-content">
                    <?php if (!empty($anuncio['imagem'])): ?>
                        <div class="anuncio-carrossel-lateral-imagem">
                            <img src="<?php echo (strpos($anuncio['imagem'], 'uploads/') === 0 ? '' : 'uploads/anuncios/') . htmlspecialchars($anuncio['imagem']); ?>"
                                 alt="<?php echo htmlspecialchars($anuncio['nome'] ?? ''); ?>"
                                 onerror="this.style.display='none'">
                        </div>
                    <?php endif; ?>
                    <div class="anuncio-carrossel-lateral-texto">
                        <h5><?php echo htmlspecialchars($anuncio['nome'] ?? ''); ?></h5>
                        <p><?php echo htmlspecialchars($anuncio['texto'] ?? ''); ?></p>
                        <?php if (!empty($anuncio['link'])): ?>
                            <a href="<?php echo htmlspecialchars($anuncio['link']); ?>" class="anuncio-carrossel-lateral-link" target="_blank" rel="noopener noreferrer">
                                Ver Mais
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="anuncios-carrossel-lateral-indicadores">
        <?php foreach ($anunciosNaoExpirados as $index => $anuncio): ?>
            <button class="anuncio-indicador-lateral <?php echo $index === 0 ? 'ativo' : ''; ?>" onclick="mostrarAnuncioCarrosselLateral(<?php echo $index; ?>)">
                <span class="anuncio-indicador-dot-lateral"></span>
            </button>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<style>
.anuncios-carrossel-lateral {
    position: fixed;
    top: 80px;
    left: 0;
    width: 340px;
    max-width: 95vw;
    z-index: 9999;
    background: var(--card-bg, #23272f);
    border-radius: 0 18px 18px 0;
    box-shadow: 4px 0 24px rgba(0,0,0,0.22);
    padding: 0.7rem 0.7rem 0.7rem 0.2rem;
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
    animation: slideInLeft 0.4s cubic-bezier(.4,1.4,.6,1) forwards;
    border-left: 4px solid var(--primary-color, #ff9800);
    backdrop-filter: blur(2px);
}
@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-60px); }
    to { opacity: 1; transform: translateX(0); }
}
.anuncios-carrossel-lateral-container {
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
}
.anuncio-carrossel-lateral-item {
    background: var(--bg-secondary, #23272f);
    border-radius: 14px;
    padding: 0.9rem 0.8rem;
    display: flex;
    gap: 0.9rem;
    align-items: center;
    box-shadow: 0 2px 12px rgba(0,0,0,0.10);
    transition: box-shadow 0.2s, transform 0.2s;
    border: 1.5px solid transparent;
    cursor: pointer;
    opacity: 0.93;
}
.anuncio-carrossel-lateral-item.ativo,
.anuncio-carrossel-lateral-item:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,0.18);
    border-color: var(--primary-color, #ff9800);
    transform: scale(1.03);
    opacity: 1;
    background: var(--card-bg, #23272f);
}
.anuncio-carrossel-lateral-imagem img {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid var(--primary-color, #ff9800);
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.anuncio-carrossel-lateral-texto {
    flex: 1;
    min-width: 0;
}
.anuncio-carrossel-lateral-texto h5 {
    margin: 0 0 0.18rem 0;
    font-size: 1.08rem;
    color: var(--primary-color, #ff9800);
    font-weight: 700;
    letter-spacing: 0.01em;
    text-shadow: 0 1px 2px rgba(0,0,0,0.10);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.anuncio-carrossel-lateral-texto p {
    margin: 0 0 0.25rem 0;
    font-size: 0.97rem;
    color: var(--text-secondary, #e0e0e0);
    line-height: 1.3;
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.anuncio-carrossel-lateral-link {
    color: var(--primary-color, #ff9800);
    text-decoration: underline;
    font-weight: 600;
    font-size: 0.97rem;
    transition: color 0.2s;
}
.anuncio-carrossel-lateral-link:hover {
    color: #fff;
    background: var(--primary-color, #ff9800);
    border-radius: 8px;
    padding: 0.1em 0.5em;
    text-decoration: none;
}
.anuncios-carrossel-lateral-indicadores {
    display: flex;
    gap: 0.4rem;
    justify-content: center;
    margin-top: 0.5rem;
}
.anuncio-indicador-lateral {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.2rem;
    outline: none;
}
.anuncio-indicador-dot-lateral {
    display: block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--border-color, #888);
    box-shadow: 0 1px 2px rgba(0,0,0,0.10);
    transition: background 0.3s, transform 0.2s;
}
.anuncio-indicador-lateral.ativo .anuncio-indicador-dot-lateral,
.anuncio-indicador-lateral:hover .anuncio-indicador-dot-lateral {
    background: var(--primary-color, #ff9800);
    transform: scale(1.2);
}
@media (max-width: 700px) {
    .anuncios-carrossel-lateral {
        width: 98vw;
        left: 0;
        right: 0;
        border-radius: 0 0 18px 18px;
        top: auto;
        bottom: 0;
        max-width: 100vw;
        flex-direction: row;
        gap: 0.2rem;
        padding: 0.2rem 0.2rem 0.2rem 0.2rem;
        border-left: none;
        border-top: 4px solid var(--primary-color, #ff9800);
        box-shadow: 0 -4px 24px rgba(0,0,0,0.18);
    }
    .anuncios-carrossel-lateral-container {
        flex-direction: row;
        gap: 0.2rem;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color, #ff9800) #23272f;
    }
    .anuncio-carrossel-lateral-item {
        min-width: 220px;
        max-width: 260px;
        flex-direction: column;
        align-items: flex-start;
        padding: 0.5rem;
    }
    .anuncio-carrossel-lateral-imagem img {
        width: 100%;
        height: 60px;
    }
}
</style>
<script>
function mostrarAnuncioCarrosselLateral(index) {
    const items = document.querySelectorAll('.anuncio-carrossel-lateral-item');
    const indicadores = document.querySelectorAll('.anuncio-indicador-lateral');
    items.forEach(item => item.classList.remove('ativo'));
    indicadores.forEach(ind => ind.classList.remove('ativo'));
    if (items[index]) items[index].classList.add('ativo');
    if (indicadores[index]) indicadores[index].classList.add('ativo');
}
</script> 
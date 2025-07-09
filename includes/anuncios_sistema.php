<?php
require_once 'classes/AnuncioManager.php';

$anuncioManager = new AnuncioManager();
$anunciosNaoExpirados = $anuncioManager->getAnunciosNaoExpirados();

echo "<!-- JSON usado: " . realpath(__DIR__ . '/../data/anuncios.json') . " -->";
echo "<!-- Anúncios não expirados encontrados: " . count($anunciosNaoExpirados) . " -->";
?>

<?php if (!empty($anunciosNaoExpirados)): ?>
<div id="anuncios-carrossel-lateral" class="anuncios-carrossel-lateral" tabindex="0" aria-label="Carrossel de anúncios">
    <button id="btn-ocultar-carrossel" class="btn-ocultar-carrossel" title="Ocultar anúncios" aria-label="Ocultar anúncios" onclick="ocultarCarrosselLateral(event)">
        &times;
        <span class="tooltip-fechar">Ocultar anúncios</span>
    </button>
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
            <button class="anuncio-indicador-lateral <?php echo $index === 0 ? 'ativo' : ''; ?>" onclick="mostrarAnuncioCarrosselLateral(<?php echo $index; ?>)" aria-label="Ir para anúncio <?php echo $index+1; ?>">
                <span class="anuncio-indicador-dot-lateral"></span>
            </button>
        <?php endforeach; ?>
    </div>
</div>
<button id="btn-reabrir-carrossel" class="btn-reabrir-carrossel" title="Mostrar anúncios" aria-label="Mostrar anúncios" style="display:none;">
    <i class="fas fa-bullhorn"></i>
    <span class="tooltip-reabrir">Mostrar anúncios</span>
</button>
<?php endif; ?>

<style>
.btn-ocultar-carrossel {
    position: absolute;
    top: 8px;
    right: 10px;
    background: transparent;
    border: none;
    color: var(--primary-color, #FF084B);
    font-size: 1.7rem;
    font-weight: bold;
    cursor: pointer;
    z-index: 10001;
    transition: color 0.2s, background 0.2s;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    line-height: 36px;
    text-align: center;
}
.btn-ocultar-carrossel:hover {
    background: var(--primary-color, #FF084B);
    color: #fff;
}
.anuncios-carrossel-lateral {
    position: fixed;
    top: 80px;
    left: 0;
    width: 250px;
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
    border-left: 4px solid var(--primary-color, #FF084B);
    backdrop-filter: blur(2px);
    opacity: 1;
    transition: opacity 0.4s cubic-bezier(.4,1.4,.6,1), visibility 0.4s;
    visibility: visible;
}
.anuncios-carrossel-lateral.oculto {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
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
    background: linear-gradient(120deg, #23272f 80%, #2d2f36 100%);
    border-radius: 16px;
    padding: 1.1rem 1rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    box-shadow: 0 4px 24px rgba(0,0,0,0.13), 0 1.5px 0.5px rgba(255,8,75,0.04);
    transition: box-shadow 0.25s, transform 0.22s, background 0.22s;
    border: 2.5px solid transparent;
    cursor: pointer;
    opacity: 0.95;
    position: relative;
    overflow: hidden;
}
.anuncio-carrossel-lateral-item.ativo,
.anuncio-carrossel-lateral-item:hover {
    box-shadow: 0 8px 32px 0 rgba(255,8,75,0.13), 0 2px 8px rgba(0,0,0,0.18);
    border-color: var(--primary-color, #FF084B);
    transform: scale(1.035);
    opacity: 1;
    background: linear-gradient(120deg, #23272f 60%, #FF084B22 100%);
}
.anuncio-carrossel-lateral-imagem img {
    width: 100px;
    height: 100px;
    margin-bottom: 10px;
    object-fit: cover;
    border-radius: 12px;
    border: 2.5px solid #fff;
    box-shadow: 0 2px 12px rgba(255,8,75,0.10), 0 0 0 3px var(--primary-color, #FF084B);
    background: #fff;
    transition: box-shadow 0.22s, border 0.22s;
}
.anuncio-carrossel-lateral-item:hover .anuncio-carrossel-lateral-imagem img {
    box-shadow: 0 4px 18px rgba(255,8,75,0.18), 0 0 0 4px var(--primary-color, #FF084B);
    border: 2.5px solid var(--primary-color, #FF084B);
}
.anuncio-carrossel-lateral-texto {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.18rem;
}
.anuncio-carrossel-lateral-texto h5 {
    margin: 0 0 0.18rem 0;
    font-size: 1.09rem;
    color: var(--primary-color, #FF084B);
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    text-shadow: 0 1px 2px rgba(0,0,0,0.10);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.anuncio-carrossel-lateral-texto p {
    margin: 0 0 0.25rem 0;
    font-size: 0.99rem;
    color: #f3f3f3;
    line-height: 1.35;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    opacity: 0.92;
}
.anuncio-carrossel-lateral-link {
    display: inline-block;
    color: #fff;
    background: linear-gradient(90deg, var(--primary-color, #FF084B) 60%, #ffb199 100%);
    border: none;
    border-radius: 8px;
    padding: 0.32em 1.1em;
    font-weight: 700;
    font-size: 0.98rem;
    text-decoration: none;
    box-shadow: 0 1px 6px rgba(255,8,75,0.10);
    margin-top: 0.1em;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s;
}
.anuncio-carrossel-lateral-link:hover {
    background: #fff;
    color: var(--primary-color, #FF084B);
    box-shadow: 0 2px 12px rgba(255,8,75,0.18);
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
    background: var(--primary-color, #FF084B);
    transform: scale(1.2);
}
.btn-reabrir-carrossel {
    position: fixed;
    left: 12px;
    top: 120px;
    z-index: 10000;
    background: var(--primary-color, #FF084B);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    font-size: 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0.85;
    transition: opacity 0.3s, background 0.2s;
}
.btn-reabrir-carrossel:hover {
    opacity: 1;
    background: #23272f;
    color: var(--primary-color, #FF084B);
}
.tooltip-reabrir {
    display: none;
    position: absolute;
    left: 120%;
    top: 50%;
    transform: translateY(-50%);
    background: #23272f;
    color: #fff;
    padding: 0.3em 0.7em;
    border-radius: 6px;
    font-size: 0.95rem;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
}
.btn-reabrir-carrossel:hover .tooltip-reabrir,
.btn-reabrir-carrossel:focus .tooltip-reabrir {
    display: block;
    opacity: 1;
}
.tooltip-fechar {
    display: none;
    position: absolute;
    top: 110%;
    left: 50%;
    transform: translateX(-50%);
    background: #23272f;
    color: #fff;
    padding: 0.3em 0.7em;
    border-radius: 6px;
    font-size: 0.95rem;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
}
.btn-ocultar-carrossel:hover .tooltip-fechar,
.btn-ocultar-carrossel:focus .tooltip-fechar {
    display: block;
    opacity: 1;
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
        border-top: 4px solid var(--primary-color, #FF084B);
        box-shadow: 0 -4px 24px rgba(0,0,0,0.18);
    }
    .anuncios-carrossel-lateral-container {
        flex-direction: row;
        gap: 0.2rem;
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color, #FF084B) #23272f;
    }
    .anuncio-carrossel-lateral-item {
        min-width: 220px;
        max-width: 260px;
        flex-direction: column;
        align-items: flex-start;
        padding: 0.7rem 0.5rem;
        gap: 0.7rem;
    }
    .anuncio-carrossel-lateral-imagem img {
        width: 100%;
        height: 60px;
    }
    .anuncio-carrossel-lateral-texto p {
        max-width: 100%;
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

function ocultarCarrosselLateral(e) {
    e && e.preventDefault();
    const carrossel = document.getElementById('anuncios-carrossel-lateral');
    const btnReabrir = document.getElementById('btn-reabrir-carrossel');
    if (carrossel) {
        carrossel.classList.add('oculto');
        setTimeout(() => {
            carrossel.style.display = 'none';
            if (btnReabrir) btnReabrir.style.display = 'flex';
        }, 400);
        setTimeout(() => {
            carrossel.style.display = '';
            carrossel.classList.remove('oculto');
            if (btnReabrir) btnReabrir.style.display = 'none';
        }, 30400); // 30s + 0.4s animação
    }
}
document.getElementById('btn-reabrir-carrossel')?.addEventListener('click', function() {
    const carrossel = document.getElementById('anuncios-carrossel-lateral');
    this.style.display = 'none';
    if (carrossel) {
        carrossel.style.display = '';
        setTimeout(() => carrossel.classList.remove('oculto'), 10);
    }
});
</script> 
</script> 
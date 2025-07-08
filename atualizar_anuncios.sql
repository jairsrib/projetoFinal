-- Script para atualizar a tabela de anúncios
-- Adicionar colunas necessárias para o novo sistema de anúncios

USE projeto_final;

-- Adicionar coluna prioridade (1 = alta, 2 = média, 3 = baixa)
ALTER TABLE anuncio ADD COLUMN prioridade INT DEFAULT 3;

-- Adicionar coluna categoria
ALTER TABLE anuncio ADD COLUMN categoria VARCHAR(50) DEFAULT 'geral';

-- Adicionar coluna data_expiracao
ALTER TABLE anuncio ADD COLUMN data_expiracao DATETIME NULL;

-- Atualizar anúncios existentes para ter prioridade padrão
UPDATE anuncio SET prioridade = 3 WHERE prioridade IS NULL;

-- Atualizar anúncios em destaque para ter prioridade alta
UPDATE anuncio SET prioridade = 1 WHERE destaque = 1;

-- Inserir alguns anúncios de exemplo com diferentes prioridades
INSERT INTO anuncio (nome, imagem, link, texto, ativo, destaque, data_cadastro, valor_anuncio, anunciante_id, prioridade, categoria) VALUES
('GameStudio Pro - Prioridade Alta', 'https://via.placeholder.com/400x200/667eea/ffffff?text=Anuncio+Alta+Prioridade', 'https://exemplo.com/jogo-novo', 'Anúncio de prioridade alta - será exibido como pop-up!', 1, 1, NOW(), 1500.00, 3, 1, 'lançamento'),
('GameStore Premium - Prioridade Média', 'https://via.placeholder.com/400x200/f093fb/ffffff?text=Anuncio+Media+Prioridade', 'https://exemplo.com/promocao', 'Anúncio de prioridade média - será exibido no carrossel lateral', 1, 0, NOW(), 800.00, 3, 2, 'promoção'),
('Evento Gaming - Prioridade Baixa', 'https://via.placeholder.com/400x200/4facfe/ffffff?text=Anuncio+Baixa+Prioridade', 'https://exemplo.com/evento', 'Anúncio de prioridade baixa - também no carrossel lateral', 1, 0, NOW(), 500.00, 3, 3, 'evento');

-- Mostrar estrutura atualizada da tabela
DESCRIBE anuncio; 
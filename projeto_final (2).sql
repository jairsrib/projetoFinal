-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Jun-2025 às 23:59
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_final`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'E-Sports'),
(2, 'Speed-Run'),
(3, 'Battle-Royale'),
(4, 'RPG');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `autor_id` int(50) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `imagem` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `texto`, `data`, `autor_id`, `categoria`, `imagem`) VALUES
(1, 'HELOO', 'aaaaaaa', '2025-06-25 04:55:32', 3, 'E-Sports', '685201c123386_img.jpg'),
(6, 'cr7 mil gols', 'hat trick contra a argentina', '2025-06-17 21:17:52', 3, 'jogo', '685205b0a20e6_img.webp'),
(7, 'Auckland City empata com Boca Juniors', 'Te pusiste nerviosa eliminado', '2025-06-24 19:46:17', 3, '1', '685b2ab91db83_img.jpg'),
(8, 'jabutia', 'ads', '2025-06-24 19:53:08', 3, 'E-Sports', '685b2c54c309c_img.png'),
(9, 'BET365', 'sDSAFSAF', '2025-06-24 23:21:07', 3, 'E-Sports', '685b5d13231c3_img.jpg'),
(10, 'Skin mais cara de todas', 'Riot Games lança uma skin de 20 mil reais na cotação atual', '2025-06-25 18:42:33', 3, 'RPG', '685c6d49c279f_img.jpg'),
(11, 'Furia se despede do IEM', 'Após derrota para Pain Gaming furia deixa o torneio', '2025-06-25 18:43:53', 3, 'E-Sports', '685c6d990b817_img.jpg'),
(12, 'Lucas1 pego dando ghost', 'Ex Pro-Player de CS é pego na live de outros streamers', '2025-06-25 18:45:35', 3, 'E-Sports', '685c6dffb165f_img.jpg'),
(13, 'Gaules termino', 'Gaules termina em uma semana e na outra ja esta com nova namorada', '2025-06-25 18:47:28', 3, 'E-Sports', '685c6e7058f5d_img.webp');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `fone` int(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` varchar(20) NOT NULL DEFAULT 'usuario',
  `imagem_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sexo`, `fone`, `email`, `senha`, `tipo`, `imagem_perfil`) VALUES
(1, '2', 'M', 2, '2@gmail.com', '$2y$10$hi4GC6JVSAq2s1bogcjgxucGM3x9Pb8jaiJlc2SMiWmvaym8/CsOy', 'usuario', NULL),
(2, 'qwe', 'M', 231, 'afds@gmail.com', '$2y$10$vdpOQxfp6tFQJuYu.Ajgbu0SdmsdEgpwQpV6sAsmvsDysYJG1nUay', 'usuario', NULL),
(3, 'jair', 'M', 12345, 'jair@gmail.com', '$2y$10$CWtFooDVWhUoWmtSld5aMeebp4D7Ycj/laXhJIKh4BuQx2SwOq8IO', 'admin', '685b6d8125cfc_perfil.jpg'),
(4, 'Julia', 'F', 12345678, 'Julia@gmail.com', '$2y$10$wdadN9wAghlH819lnekZge2KcnaB2I3uBsh2lJEfuXD1d7z2IQmNa', 'usuario', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor` (`autor_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

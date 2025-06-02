-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/05/2025 às 22:43
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto de vida`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `data_de_registro` datetime NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `theme_color` varchar(50) DEFAULT 'theme-base',
  `background_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `description`, `password`, `data_de_registro`, `profile_picture`, `theme_color`, `background_image`) VALUES
(4, 'jonata', 'jonatas@docente.br', 'meu Deus, meu senhor me ajuda por favor!', '$2y$10$8Nv0DHAotlQ4VUcZm.VK8evTCkFnZrR/lvjDAgoFJmJE7zveFpxy6', '2025-03-28 14:54:10', 'img/67ed0fc589c6d_7ugE.gif', 'theme-base', NULL),
(5, 'bernini', 'bernini@bernini.com', 'sor bernas senai', '1234', '2025-03-28 18:29:22', 'img/67e6e878e2c5b_OKUa.gif', 'theme-base', NULL),
(6, 'Rafa', 'rafael@gmail.com', '', '1234', '2025-03-28 19:33:54', 'img/67e6ebc794cf4_XGrF.gif', 'theme-base', NULL),
(7, 'roberto', 'robertohenryck365@gmail.com', 'afawdawdaw', '$2y$10$RCA01/hwl9Vi.ZjRl/FjQ.k0Rj/4TaN/cHrxdSDHar/Mw6hkpBPvW', '2025-04-02 18:42:02', 'img/67ed691da037b_OKUa.gif', 'theme-base', NULL),
(8, 'Eric', 'ericsouzapalma123@gmail.com', 'oi meu nome é Eric e este é o meu projeto de vida', '$2y$10$alK5Xk0uZvt9Ys/zT5pLm.45soOKN6bfxyT0QXjNII2VJ9vu4c/7G', '2025-04-02 19:20:11', 'img/681b870ba1891_49edb7c66442d7362f7811eab9d974fc.jpg', 'theme-purple', 'img/banner_681bc3f971b2e.jpg'),
(9, 'marim', 'marim@gmail.com', NULL, '555', '2025-04-04 17:56:25', NULL, 'theme-base', NULL),
(10, 'Davi', 'Davi@gmail.com', NULL, '$2y$10$YCKu6bPEhnWbc4Na2rh16.lCoKrkyDDpcfbn6OI3a9NXOXonEvO4m', '2025-04-04 18:10:35', NULL, 'theme-base', NULL),
(11, 'catarina', 'catarina@gmail.com', NULL, '$2y$10$17hkY1Z1cobIV1fpEFP4quB3aMpL.hxNIse//ct5mNu5N4txLpzl2', '2025-04-04 18:12:23', NULL, 'theme-base', NULL),
(12, 'jonatas', 'jonatas.goncalves@sp.senai.br', 'professor do tecnico de desenvolvimento de sistemas', '$2y$10$ioo5KdmxZPy/L4cTdJlJr.wggppupiqiA.UelnrS953BnEqKbK5DK', '2025-04-09 15:56:21', 'img/67f6874466791_7ugE.gif', 'theme-base', NULL),
(13, 'qrtyuiop', 'teste1@gmail.com', NULL, '$2y$10$HUsAX7IDH1dyIgE1xePsy.ZPfhCRoIC1xpyJQs1GDikH1L/1U2LiO', '2025-04-25 20:49:09', NULL, 'theme-base', NULL),
(14, 'Joao', 'thiago@gmail.com', NULL, '$2y$10$vCK5VoVzoQ0dy0nTJcrOj.3SwpWF2mpWKUvCFZXnDvc1D5uEQRuSq', '2025-04-30 14:41:44', 'img/68121ad00e935_82486265.jfif', 'theme-base', NULL),
(15, 'Erictest', 'erictest@gmail.com', NULL, '$2y$10$hwGxdjzaHv5uUyuAshEyhuiZoU7XDbx2UFPNh9vtMLhS9a/dcSvWq', '2025-05-07 17:57:19', 'img/681b82fea280f_82486265.jfif', 'theme-yellow', 'img/banner_681b914e553e7.jpg'),
(16, 'Adriana Linda', 'apalma@gmail.com', 'MULHER MARAVILHA', '$2y$10$AwU.WkPeQRUPdqlrDK0/p.dpGXE5K88wSIfM6qSsOlqkbW/Pt81wy', '2025-05-08 01:17:39', 'img/681bea5a45aa0_67e6d5c95b13c_OKUa.gif', 'theme-green', 'img/banner_681bea520bf6b.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

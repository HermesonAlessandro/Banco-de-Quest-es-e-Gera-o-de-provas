-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 03-Abr-2025 às 00:43
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `concurs_bank`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `cpf` bigint(20) NOT NULL,
  `nome_completo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `tipo_de_perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`cpf`, `nome_completo`, `email`, `senha`, `tipo_de_perfil`) VALUES
(7775692301, 'Hermeson Alessandro', 'hermesonalessandro@gmail.com', '$2y$10$jcMQFIOgSnhqE.OjB70l2Oe62klG.D7nOARnLQyGWir', 'Aluno'),
(7775692302, 'Hermeson Alessandro', 'hermesonalessandro@gmail.com', '$2y$10$SYvDC96LGybrL5zU5wfR2uW6KvyBSOLANlg5R4ZLytg', 'Aluno'),
(7775692308, 'Hermeson Alessandro', 'hermesonalessandro@gmail.com', '$2y$10$GKnXL/3l2AXgS/.NriovNephvWWqAFre2DQTkGSOsLn', 'Aluno'),
(7775692309, 'Hermeson Alessandro', 'hermesonalessandro@gmail.com', '$2y$10$wVWQiL4q0E97Vacfo6xNXu7uGChNTYIhCuA81iOIEhI', 'Aluno');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores`
--

CREATE TABLE `professores` (
  `cpf` bigint(20) NOT NULL,
  `nome_completo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `tipo_de_perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessao`
--

CREATE TABLE `sessao` (
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_de_perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`cpf`);

--
-- Índices para tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`cpf`);

--
-- Índices para tabela `sessao`
--
ALTER TABLE `sessao`
  ADD UNIQUE KEY `unique_email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

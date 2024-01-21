-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 21-Jan-2024 às 02:03
-- Versão do servidor: 10.6.16-MariaDB-cll-lve
-- versão do PHP: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dventura_diodav`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `body_type` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `type`, `body_type`, `name`, `price`, `image`, `description`) VALUES
(1, 'pants', 'men', 'Man\'s Pants', 19.99, 'pants.jpg', 'For sure good looking pants'),
(2, 'shirts', 'women', 'Woman\'s Shirt', 39.99, 'shirt.jpeg', 'For sure a good looking shirt'),
(3, 'shoes', 'kids', 'Kids Shoes', 29.99, 'shoes.jpeg', 'For sure some good looking shoes'),
(4, 'pants', 'kids', 'Kids Pants', 9.99, 'kids_pants.jpg', 'For sure good looking kids pants'),
(5, 'pants', 'women', 'Woman\'s Pants', 29.99, 'woman_pants.jpg', 'For sure good looking women\'s pants'),
(6, 'shoes', 'men', 'Man\'s Shoes', 79.99, 'man_shoes.jpg', 'For sure good looking man\'s shoes'),
(7, 'shirts', 'men', 'Man\'s Shirt', 29.99, 'man_shirt.jpg', 'For sure a good looking shirt'),
(12, 'shoes', 'women', 'Woman\'s Shoes', 69.99, 'woman_shoes.jpg', 'For sure good looking women\'s shoes'),
(13, 'shirts', 'kids', 'Kids Shirt', 25, 'kids_shirt.jpg', 'For sure a good looking kids shirt');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2021 at 01:35 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_restaurante`
--

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE `bonus` (
  `codCliente` int(11) NOT NULL,
  `valor` float NOT NULL,
  `ultimoGanho` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bonus`
--

INSERT INTO `bonus` (`codCliente`, `valor`, `ultimoGanho`) VALUES
(1, 1.41, '2020-11-29'),
(19, 36.97, '2020-11-28');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `codCliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `bonus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`codCliente`, `nome`, `cpf`, `email`, `bonus`) VALUES
(1, 'João Gabriel Setubal Pires', '86279336506', 'jgspires@msn.com', 1),
(19, 'Marcela Braga Bahia', '08406550538', 'mahbraga0@gmail.com', 19);

-- --------------------------------------------------------

--
-- Table structure for table `funcionarios`
--

CREATE TABLE `funcionarios` (
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `gerente` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `funcionarios`
--

INSERT INTO `funcionarios` (`cpf`, `nome`, `senha`, `gerente`) VALUES
('00000000000', 'Admilson Cleiton Rasta', 'admin', 1),
('11111111111', 'Rémi Le Souris', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `itens`
--

CREATE TABLE `itens` (
  `codItens` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` float NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `descSupplier` text NOT NULL,
  `ingredientes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `itens`
--

INSERT INTO `itens` (`codItens`, `nome`, `preco`, `tipo`, `descSupplier`, `ingredientes`) VALUES
(2, 'Suco de limão (Copo 300ml)', 10.55, 2, 'Péssimo sucos', NULL),
(4, 'Empanada de Frango', 24.9, 1, 'Apetitosa empanada de frango temperada com indisputavelmente deliciosas especiarias árabes.', 'Frango desfiado, massa a base de farinha de trigo, salsa, agrião, cebolinha e manteiga de origens árabes.'),
(5, 'Suco de Beterraba (Copo 300ml)', 10.5, 2, 'Beterraba sucos', NULL),
(6, 'Escondidinho de Frango', 42.9, 1, 'Delicioso purê de aipim recheado com fatias de peito de frango.', 'Aipim, manteiga, sal, peito de frango, especiarias.'),
(7, 'Refrigerante de Uva (Lata 350ml)', 12.5, 2, 'Refrigerantes Refrigera', NULL),
(8, 'Torta de Chocolate (Fatia)', 36.9, 1, 'Torta do mais delicioso chocolate ao leite possível, com cobertura de ganache para agradar mesmo ao mais exigente paladar.', 'Chocolate ao leite, leite, creme de leite, leite condensado, derivados de leite.'),
(9, 'Refrigerante de Laranja (Lata 350ml)', 12.5, 2, 'Kel\'s Refris', NULL),
(10, 'Refrigerante de Guaraná (Lata 350ml)', 12.5, 2, 'Direto da Amazônia', NULL),
(11, 'Vinho do Porto (Taça 100ml)', 40, 2, 'Fazendas Setubal', NULL),
(12, 'Vinho Sauvignon Blanc (Garrafa 750ml)', 49.9, 2, 'Punta del Este', NULL),
(13, 'Filê de Tilápia ao Molho Aioli', 37.9, 1, 'Incrível filé de tilápia sem espinhas coberto pelo delicioso molho aioli que você respeita.', 'Tilápia inteira (exceto a cabeça), alho, cebola, sal, creme de leite e especiarias.'),
(14, 'Cerveja Colorado Indica Pale Ale (Garrafa 600ml)', 20.9, 2, 'Brasilstar', NULL),
(15, 'Cerveja Colombina Pepper Lager (Garrafa 600ml)', 20.9, 2, 'Brasilstar', NULL),
(16, 'Cerveja Chimay Blue (Garrafa 600ml)', 39.9, 2, 'Guinness Beers', NULL),
(17, 'Água (Garrafa 500ml)', 30.9, 2, 'Águas Caras', NULL),
(18, 'Picanha ao Molho Barbecue', 47.6, 1, 'Suculenta picanha temperada com especiarias e sazón ao delicioso molho barbecue.', 'Picanha, molho barbecue, sazón, sal, alho e cebola.'),
(19, 'Bolo de Chocolate (Fatia)', 10.5, 1, 'é um bolo', 'farinha e chocolate com açucar\r\n'),
(20, 'Bolo de Morango (Fatia)', 10.5, 1, 'Bolo de chocolate, delicioso!', 'Farinha, chocolate, manteiga, açucar.');

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `codPedido` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `qtd` int(11) NOT NULL DEFAULT 1,
  `estado` int(11) NOT NULL,
  `totalPedido` float NOT NULL DEFAULT 0,
  `codCliente` int(11) NOT NULL,
  `mesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`codCliente`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`codCliente`),
  ADD KEY `fk_bonus_clientes_idx` (`bonus`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`codItens`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`codPedido`),
  ADD KEY `fk_clientes_pedidos_idx` (`codCliente`),
  ADD KEY `fk_itens_pedidos_idx` (`item`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `codCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `itens`
--
ALTER TABLE `itens`
  MODIFY `codItens` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `codPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_clientes_pedidos` FOREIGN KEY (`codCliente`) REFERENCES `clientes` (`codCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

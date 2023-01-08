-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Set-2019 às 20:08
-- Versão do servidor: 10.1.39-MariaDB
-- versão do PHP: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_caixas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_avaliacao`
--

CREATE TABLE `tb_avaliacao` (
  `id_avaliacao` int(11) NOT NULL,
  `id_emprestimo` int(11) NOT NULL,
  `avaliacao` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_caixa`
--

CREATE TABLE `tb_caixa` (
  `id_caixa` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `area_tematica` varchar(60) NOT NULL,
  `descricao` varchar(1024) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `disponibilidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

CREATE TABLE `tb_cliente` (
  `id_cliente` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `instituicao` varchar(50) NOT NULL,
  `nivel` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_cliente`
--

INSERT INTO `tb_cliente` (`id_cliente`, `cpf`, `nome`, `telefone`, `email`, `instituicao`, `nivel`) VALUES
(45, '04120411974', 'Marlon', '(41) 99927 9983', 'marlon', 'MAE', 'adm'),
(46, '123', 'Usuário', '(45) 98989-8989', 'apo@apo.com', 'Paralelos do sucesso', 'us'),
(47, '02822697973', 'Wesley Ventura', '(41) 37211 200', 'wesley@ufpr.br', 'MAE-PGUA', 'us'),
(48, '23104042098', 'Cidadão', '(41) 85858 5855', 'cidadao@email.com', 'IFPR Paranaguá', 'us'),
(49, '04167109999', 'Renata', '(41) 55555 5555', 'renata@ufpr.br', 'MAE RT', 'adm'),
(50, '67455162090', 'Astolfo', '(75) 87587 5875', 'astalavista@baby.com', 'Que horas', 'us');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_devolucao`
--

CREATE TABLE `tb_devolucao` (
  `id_devolucao` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_emprestimo` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_emprestimo`
--

CREATE TABLE `tb_emprestimo` (
  `id_emprestimo` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `data_emprestimo` date DEFAULT NULL,
  `data_devolucao` date DEFAULT NULL,
  `data_retirada` date DEFAULT NULL,
  `id_caixa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_parecer`
--

CREATE TABLE `tb_parecer` (
  `id_parecer` int(11) NOT NULL,
  `id_emprestimo` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `observacoes` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `fk_emp_av` (`id_emprestimo`);

--
-- Indexes for table `tb_caixa`
--
ALTER TABLE `tb_caixa`
  ADD PRIMARY KEY (`id_caixa`);

--
-- Indexes for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indexes for table `tb_devolucao`
--
ALTER TABLE `tb_devolucao`
  ADD PRIMARY KEY (`id_devolucao`),
  ADD KEY `fk_adm_dev` (`id_adm`),
  ADD KEY `fk_emp_dev` (`id_emprestimo`);

--
-- Indexes for table `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD PRIMARY KEY (`id_emprestimo`),
  ADD KEY `fk_caixa` (`id_caixa`),
  ADD KEY `fk_cliente` (`id_cliente`);

--
-- Indexes for table `tb_parecer`
--
ALTER TABLE `tb_parecer`
  ADD PRIMARY KEY (`id_parecer`),
  ADD KEY `fk_emprestimo` (`id_emprestimo`),
  ADD KEY `fk_adm` (`id_adm`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  MODIFY `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_caixa`
--
ALTER TABLE `tb_caixa`
  MODIFY `id_caixa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_cliente`
--
ALTER TABLE `tb_cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tb_devolucao`
--
ALTER TABLE `tb_devolucao`
  MODIFY `id_devolucao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  MODIFY `id_emprestimo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_parecer`
--
ALTER TABLE `tb_parecer`
  MODIFY `id_parecer` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_avaliacao`
--
ALTER TABLE `tb_avaliacao`
  ADD CONSTRAINT `fk_emp_av` FOREIGN KEY (`id_emprestimo`) REFERENCES `tb_emprestimo` (`id_emprestimo`);

--
-- Limitadores para a tabela `tb_devolucao`
--
ALTER TABLE `tb_devolucao`
  ADD CONSTRAINT `fk_adm_dev` FOREIGN KEY (`id_adm`) REFERENCES `tb_cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_emp_dev` FOREIGN KEY (`id_emprestimo`) REFERENCES `tb_emprestimo` (`id_emprestimo`);

--
-- Limitadores para a tabela `tb_emprestimo`
--
ALTER TABLE `tb_emprestimo`
  ADD CONSTRAINT `fk_caixa` FOREIGN KEY (`id_caixa`) REFERENCES `tb_caixa` (`id_caixa`),
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`);

--
-- Limitadores para a tabela `tb_parecer`
--
ALTER TABLE `tb_parecer`
  ADD CONSTRAINT `fk_adm` FOREIGN KEY (`id_adm`) REFERENCES `tb_cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_emprestimo` FOREIGN KEY (`id_emprestimo`) REFERENCES `tb_emprestimo` (`id_emprestimo`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `defineatrasos` ON SCHEDULE EVERY 1 HOUR STARTS '2019-09-12 16:10:00' ON COMPLETION NOT PRESERVE ENABLE DO update tb_emprestimo
            set status = 'atrasado'
            where id_emprestimo IN 
                (select * from (SELECT e.id_emprestimo
                    from tb_emprestimo e
                    where e.status = 'retirado' AND e.data_devolucao < now()) _emp)$$

CREATE DEFINER=`root`@`localhost` EVENT `definecancelamentos` ON SCHEDULE EVERY 1 HOUR STARTS '2019-09-12 16:10:00' ON COMPLETION NOT PRESERVE ENABLE DO update tb_emprestimo
            set status = 'cancelado'
            where id_emprestimo IN 
                (select * from (SELECT e.id_emprestimo
                    from tb_emprestimo e
                    where e.status = 'aprovado' AND e.data_devolucao < now()) _emp)$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

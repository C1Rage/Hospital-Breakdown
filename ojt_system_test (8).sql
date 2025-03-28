-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 27, 2025 at 08:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ojt_system_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `consignor`
--

CREATE TABLE `consignor` (
  `id` int(11) NOT NULL,
  `consignor_id` int(11) NOT NULL,
  `or_number` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `particulars` text NOT NULL,
  `dr` decimal(10,2) DEFAULT 0.00,
  `cr` decimal(10,2) DEFAULT 0.00,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `old_balance` decimal(10,2) DEFAULT 0.00,
  `new_balance` decimal(10,2) DEFAULT 0.00,
  `eapip_bd_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consignor`
--

INSERT INTO `consignor` (`id`, `consignor_id`, `or_number`, `date`, `name`, `particulars`, `dr`, `cr`, `remarks`, `created_at`, `old_balance`, `new_balance`, `eapip_bd_id`) VALUES
(775, 13, '237y238', '2025-03-27', '', '', 0.00, 555.00, '', '2025-03-27 05:47:37', 0.00, 555.00, 114),
(776, 14, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(777, 15, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(778, 16, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(779, 17, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(780, 18, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(781, 19, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(782, 20, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(783, 21, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(784, 22, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(785, 23, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(786, 24, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114),
(787, 28, '237y238', '2025-03-27', '', '', 0.00, 555.00, NULL, '2025-03-27 05:47:37', 0.00, 555.00, 114);

--
-- Triggers `consignor`
--
DELIMITER $$
CREATE TRIGGER `after_insert_consignor` AFTER INSERT ON `consignor` FOR EACH ROW BEGIN
    UPDATE consignor_liststb
    SET balance = NEW.new_balance
    WHERE id = NEW.consignor_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_consignor` AFTER UPDATE ON `consignor` FOR EACH ROW BEGIN
    UPDATE consignor_liststb
    SET balance = NEW.new_balance
    WHERE id = NEW.consignor_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_consignor` BEFORE INSERT ON `consignor` FOR EACH ROW BEGIN
    DECLARE last_balance DECIMAL(10,2);

    -- Fetch the latest balance from consignor_liststb
    SELECT balance INTO last_balance 
    FROM consignor_liststb 
    WHERE id = NEW.consignor_id 
    LIMIT 1;

    -- If no previous balance exists, set old_balance to 0
    IF last_balance IS NULL THEN
        SET last_balance = 0.00;
    END IF;

    -- Set old_balance from consignor_liststb.balance
    SET NEW.old_balance = last_balance;

    -- Compute new_balance dynamically
    SET NEW.new_balance = NEW.old_balance + NEW.cr - NEW.dr;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `consignor_liststb`
--

CREATE TABLE `consignor_liststb` (
  `id` int(11) NOT NULL,
  `conName` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consignor_liststb`
--

INSERT INTO `consignor_liststb` (`id`, `conName`, `description`, `created_at`, `balance`) VALUES
(13, 'CLEARVEU', NULL, '2025-02-24 01:57:55', 555.00),
(14, 'FAS', NULL, '2025-02-24 01:57:55', 555.00),
(15, 'FRESENIUS', NULL, '2025-02-24 01:57:55', 555.00),
(16, 'INFIMAX', NULL, '2025-02-24 01:57:55', 555.00),
(17, 'IVAXX', NULL, '2025-02-24 01:57:55', 555.00),
(18, 'MACRIK', NULL, '2025-02-24 01:57:55', 555.00),
(19, 'MAHINTANA', NULL, '2025-02-24 01:57:55', 555.00),
(20, 'RED CROSS', NULL, '2025-02-24 01:57:55', 555.00),
(21, 'RUSSAN', NULL, '2025-02-24 01:57:55', 555.00),
(22, 'SANNOVEX', NULL, '2025-02-24 01:57:55', 555.00),
(23, 'TWINCIRCA', NULL, '2025-02-24 01:57:55', 555.00),
(24, 'ZION', NULL, '2025-02-24 01:57:55', 555.00),
(25, 'HEA', NULL, '2025-03-06 05:53:02', 0.00),
(26, 'PS', NULL, '2025-03-06 05:53:02', 0.00),
(27, 'POOL', NULL, '2025-03-06 05:53:40', 0.00),
(28, 'OTR-PAYBLS-PF', NULL, '2025-03-06 05:53:40', 555.00);

-- --------------------------------------------------------

--
-- Table structure for table `eapip_breakdown`
--

CREATE TABLE `eapip_breakdown` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `or_number` varchar(255) NOT NULL,
  `particulars` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `breakdown` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `hospital_fees` decimal(10,2) DEFAULT NULL,
  `total_amount_consignor` decimal(10,2) DEFAULT NULL,
  `clearveu` decimal(10,2) NOT NULL,
  `fas` decimal(10,2) NOT NULL,
  `fresenius` decimal(10,2) NOT NULL,
  `infimax` decimal(10,2) NOT NULL,
  `ivaxx` decimal(10,2) NOT NULL,
  `macrik` decimal(10,2) NOT NULL,
  `mahintana` decimal(10,2) NOT NULL,
  `red_cross` decimal(10,2) NOT NULL,
  `russan` decimal(10,2) NOT NULL,
  `sannovex` decimal(10,2) NOT NULL,
  `twincirca` decimal(10,2) NOT NULL,
  `zion` decimal(10,2) NOT NULL,
  `otr_paybls_pf` decimal(10,2) NOT NULL,
  `total` decimal(20,2) NOT NULL,
  `diff` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eapip_breakdown`
--

INSERT INTO `eapip_breakdown` (`id`, `date`, `or_number`, `particulars`, `total_amount`, `breakdown`, `amount`, `hospital_fees`, `total_amount_consignor`, `clearveu`, `fas`, `fresenius`, `infimax`, `ivaxx`, `macrik`, `mahintana`, `red_cross`, `russan`, `sannovex`, `twincirca`, `zion`, `otr_paybls_pf`, `total`, `diff`, `created_at`) VALUES
(114, '2025-03-27', '237y238', 'lollipop wdfsdj', 100.00, 1244.00, 13556.00, 1341.00, 11660.00, 5555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 555.00, 12215.00, 12312.00, '2025-03-27 05:47:37');

--
-- Triggers `eapip_breakdown`
--
DELIMITER $$
CREATE TRIGGER `before_insert_update_eapip_breakdown` BEFORE INSERT ON `eapip_breakdown` FOR EACH ROW BEGIN
    -- Sum from clearveu to zion for total_amount_consignor
    SET NEW.total_amount_consignor = 
        NEW.clearveu + NEW.fas + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion;

    -- Sum hospital_fees, total_amount_consignor, and po_paybls_pf for amount
    SET NEW.amount = IFNULL(NEW.hospital_fees, 0) + IFNULL(NEW.total_amount_consignor, 0) + IFNULL(NEW.otr_paybls_pf, 0);

    -- Subtract breakdown from amount for diff
    SET NEW.diff = IFNULL(NEW.breakdown, 0) - IFNULL(NEW.amount, 0);
    
    -- Sum from clearveu to po_paybls_pf for total column
    SET NEW.total = 
        NEW.clearveu + NEW.fas + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion + NEW.otr_paybls_pf;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_eapip_breakdown` BEFORE UPDATE ON `eapip_breakdown` FOR EACH ROW BEGIN
    -- Sum from clearveu to zion for total_amount_consignor
    SET NEW.total_amount_consignor = 
        NEW.clearveu + NEW.fas + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion;

    -- Sum hospital_fees, total_amount_consignor, and po_paybls_pf for amount
    SET NEW.amount = IFNULL(NEW.hospital_fees, 0) + IFNULL(NEW.total_amount_consignor, 0) + IFNULL(NEW.otr_paybls_pf, 0);

    -- Subtract breakdown from amount for diff
    SET NEW.diff =IFNULL(NEW.amount, 0) -  IFNULL(NEW.breakdown, 0);

    -- Sum from clearveu to po_paybls_pf for total column
    SET NEW.total = 
        NEW.clearveu + NEW.fas + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion + NEW.otr_paybls_pf;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_breakdown`
--

CREATE TABLE `hospital_breakdown` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `or_number` varchar(50) NOT NULL,
  `particulars` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `breakdown` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `hospital_fees` decimal(10,2) NOT NULL,
  `total_amount_consignor` decimal(10,2) NOT NULL,
  `clearveu` decimal(10,2) NOT NULL,
  `fresenius` decimal(10,2) NOT NULL,
  `infimax` decimal(10,2) NOT NULL,
  `ivaxx` decimal(10,2) NOT NULL,
  `macrik` decimal(10,2) NOT NULL,
  `mahintana` decimal(10,2) NOT NULL,
  `red_cross` decimal(10,2) NOT NULL,
  `russan` decimal(10,2) NOT NULL,
  `sannovex` decimal(10,2) NOT NULL,
  `twincirca` decimal(10,2) NOT NULL,
  `zion` decimal(10,2) NOT NULL,
  `otr_paybls_pf` decimal(10,2) NOT NULL,
  `pf_pooling` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `diff` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_breakdown`
--

INSERT INTO `hospital_breakdown` (`id`, `date`, `or_number`, `particulars`, `total_amount`, `breakdown`, `amount`, `hospital_fees`, `total_amount_consignor`, `clearveu`, `fresenius`, `infimax`, `ivaxx`, `macrik`, `mahintana`, `red_cross`, `russan`, `sannovex`, `twincirca`, `zion`, `otr_paybls_pf`, `pf_pooling`, `total`, `diff`, `created_at`) VALUES
(1, '2025-03-21', '223', 'dfvdfe', 12.00, 11.00, 87.00, 45.00, 35.00, 1.00, 2.00, 3.00, 4.00, 3.00, 5.00, 7.00, 5.00, 1.00, 2.00, 2.00, 4.00, 3.00, 42.00, -76.00, '2025-03-21 08:08:26');

--
-- Triggers `hospital_breakdown`
--
DELIMITER $$
CREATE TRIGGER `before_insert_update_hospital_breakdown` BEFORE INSERT ON `hospital_breakdown` FOR EACH ROW BEGIN
    -- Sum from clearveu to zion for total_amount_consignor
    SET NEW.total_amount_consignor = 
        NEW.clearveu + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion;

    -- Sum hospital_fees, total_amount_consignor, and po_paybls_pf for amount
    SET NEW.amount = IFNULL(NEW.hospital_fees, 0) + IFNULL(NEW.total_amount_consignor, 0) + IFNULL(NEW.otr_paybls_pf, 0) + IFNULL(NEW.pf_pooling, 0);

    -- Subtract breakdown from amount for diff
    SET NEW.diff = IFNULL(NEW.breakdown, 0) - IFNULL(NEW.amount, 0);
    
    -- Sum from clearveu to po_paybls_pf for total column
    SET NEW.total = 
        NEW.clearveu + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion + NEW.otr_paybls_pf + NEW.pf_pooling;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_hospital_breakdown` BEFORE UPDATE ON `hospital_breakdown` FOR EACH ROW BEGIN
    -- Sum from clearveu to zion for total_amount_consignor
    SET NEW.total_amount_consignor = 
        NEW.clearveu + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion;

    -- Sum hospital_fees, total_amount_consignor, and po_paybls_pf for amount
    SET NEW.amount = IFNULL(NEW.hospital_fees, 0) + IFNULL(NEW.total_amount_consignor, 0) + IFNULL(NEW.otr_paybls_pf, 0) + IFNULL(NEW.pf_pooling, 0);

    -- Subtract breakdown from amount for diff
    SET NEW.diff = IFNULL(NEW.breakdown, 0) - IFNULL(NEW.amount, 0);
    
    -- Sum from clearveu to po_paybls_pf for total column
    SET NEW.total = 
        NEW.clearveu + NEW.fresenius + NEW.infimax + NEW.ivaxx +
        NEW.macrik + NEW.mahintana + NEW.red_cross + NEW.russan + NEW.sannovex +
        NEW.twincirca + NEW.zion + NEW.otr_paybls_pf + NEW.pf_pooling;

END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consignor`
--
ALTER TABLE `consignor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consignor_id` (`consignor_id`),
  ADD KEY `fk_eapip_bd_id` (`eapip_bd_id`);

--
-- Indexes for table `consignor_liststb`
--
ALTER TABLE `consignor_liststb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`conName`);

--
-- Indexes for table `eapip_breakdown`
--
ALTER TABLE `eapip_breakdown`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `or_number` (`or_number`);

--
-- Indexes for table `hospital_breakdown`
--
ALTER TABLE `hospital_breakdown`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consignor`
--
ALTER TABLE `consignor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=788;

--
-- AUTO_INCREMENT for table `consignor_liststb`
--
ALTER TABLE `consignor_liststb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `eapip_breakdown`
--
ALTER TABLE `eapip_breakdown`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `hospital_breakdown`
--
ALTER TABLE `hospital_breakdown`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consignor`
--
ALTER TABLE `consignor`
  ADD CONSTRAINT `fk_consignor_id` FOREIGN KEY (`consignor_id`) REFERENCES `consignor_liststb` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eapip_bd_id` FOREIGN KEY (`eapip_bd_id`) REFERENCES `eapip_breakdown` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

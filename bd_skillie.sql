-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 04:25 AM
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
-- Database: `bd_skillie`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carreiras`
--

CREATE TABLE `carreiras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `desc` text DEFAULT NULL,
  `categoria` varchar(255) NOT NULL,
  `atributosIniciais` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`atributosIniciais`)),
  `imagem` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carreiras`
--

INSERT INTO `carreiras` (`id`, `nome`, `desc`, `categoria`, `atributosIniciais`, `imagem`, `created_at`, `updated_at`) VALUES
(2, 'Psicólogo', 'Um dos seus pacientes te ligou urgentemente pedindo por ajuda.', 'Humanas', '{\"estresse\":0,\"dinheiro\":0,\"reputacao\":1}', 'https://img.favpng.com/15/13/5/psychology-psychologist-dialectical-behavior-therapy-psychotherapist-png-favpng-jJdUdXz74AAaMD4DJBssMMNp3.jpg', '2025-11-19 06:18:09', '2025-11-19 06:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `cartas`
--

CREATE TABLE `cartas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `efeitos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`efeitos`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cartas`
--

INSERT INTO `cartas` (`id`, `nome`, `desc`, `imagem`, `efeitos`, `created_at`, `updated_at`) VALUES
(3, 'Socializar', 'você gasta um tempo para se enturmar.', 'https://thumbs.dreamstime.com/b/business-emoticon-handshake-2986268.jpg', '{\"estresse\":\"2\",\"dinheiro\":\"0\",\"reputacao\":\"2\"}', '2025-11-19 05:48:51', '2025-11-19 05:48:51'),
(4, 'Trapacear', 'Você é ardileiro com seus companheiros para tomar vantagem.', 'https://bluemoji.io/cdn-proxy/646218c67da47160c64a84d5/64fad55a7adf2f455a7efe35_41.png', '{\"estresse\":-1,\"dinheiro\":4,\"reputacao\":-3}', '2025-11-19 05:50:23', '2025-11-19 06:06:02'),
(5, 'Tirar uma folga', 'você prefere passar um tempo descansando a se esforçar.', 'https://ih1.redbubble.net/image.3510304752.9255/st,small,507x507-pad,600x600,f8f8f8.jpg', '{\"estresse\":-4,\"dinheiro\":-2,\"reputacao\":0}', '2025-11-19 05:52:45', '2025-11-19 05:52:58'),
(6, 'Ajudar', 'você ajuda o próximo.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8lRMKkPDUh3VGvwTIybeVqUXVRdNkOly9HVp1OKJAGBTgOCi7W7nIojYY2_OA4xoEe5M&usqp=CAU', '{\"estresse\":\"1\",\"dinheiro\":\"0\",\"reputacao\":\"3\"}', '2025-11-19 05:55:01', '2025-11-19 05:55:01'),
(7, '110%', 'você se esforça excepcionalmente.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrchUYpbx6kRS1ppFduP2XMhTA2okcumx-SA&s', '{\"estresse\":\"3\",\"dinheiro\":\"4\",\"reputacao\":\"2\"}', '2025-11-19 05:57:27', '2025-11-19 05:57:27'),
(8, 'Perito', 'você toma um tempo para aprender uma coisa nova.', 'https://c8.alamy.com/comp/2BWX883/nerd-emoticon-2BWX883.jpg', '{\"estresse\":\"2\",\"dinheiro\":\"1\",\"reputacao\":\"3\"}', '2025-11-19 05:58:45', '2025-11-19 05:58:45'),
(9, 'Eu sou melhor!', 'você faz seu trabalho propositalmente melhor do que os seus colegas.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTZn3J5vCVNHIPsD6SP5i2ged_IWZoQfYiy1g&s', '{\"estresse\":\"2\",\"dinheiro\":\"4\",\"reputacao\":\"-2\"}', '2025-11-19 06:04:15', '2025-11-19 06:04:15'),
(10, 'Emprestar', 'você empresta um pouco a um colega necessitado.', 'https://www.shutterstock.com/image-vector/happy-emoji-emoticon-holding-dollar-260nw-197508515.jpg', '{\"estresse\":\"-2\",\"dinheiro\":\"-2\",\"reputacao\":\"4\"}', '2025-11-19 06:05:47', '2025-11-19 06:05:47'),
(11, 'Reorganizar', 'Você reorganiza as coisas.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTfzMBaXIa5t3Zxf-Mbz5jo6ETqV7XWgrAo9Q&s', '{\"estresse\":\"3\",\"dinheiro\":\"2\",\"reputacao\":\"0\"}', '2025-11-19 06:13:13', '2025-11-19 06:13:13'),
(12, 'Repreender', 'você repreende uma má conduta.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQl_dc7D3hRR0CaoT3H1KIw0lJFXnGGhQshfQ&s', '{\"estresse\":\"-4\",\"dinheiro\":\"0\",\"reputacao\":\"-2\"}', '2025-11-19 06:15:26', '2025-11-19 06:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historicos`
--

CREATE TABLE `historicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resultado` varchar(255) NOT NULL,
  `data_jogo` datetime NOT NULL,
  `atributos_finais` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`atributos_finais`)),
  `carreira_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `historicos`
--

INSERT INTO `historicos` (`id`, `resultado`, `data_jogo`, `atributos_finais`, `carreira_id`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 'Vitória: Você completou todas as situações.', '2025-11-19 03:23:12', '{\"estresse\":2,\"dinheiro\":4,\"reputacao\":3}', 2, 1, '2025-11-19 06:23:12', '2025-11-19 06:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_17_230010_create_carreiras_table', 1),
(5, '2025_11_17_232000_create_cartas_table', 1),
(6, '2025_11_17_232312_create_situacoes_table', 1),
(7, '2025_11_17_234833_create_historicos_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6AU7tL9tTJiktmHK61SgXGNJMjoi8AfmOoIn8pbs', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNW5SRnhWTkRick1CemhYeE1aMGFHSEc3YWJKWDB1WjhaMTR4dkwwVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZXJmaWw/c2hvdz00Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1763522656);

-- --------------------------------------------------------

--
-- Table structure for table `situacoes`
--

CREATE TABLE `situacoes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `carreira_id` bigint(20) UNSIGNED NOT NULL,
  `decisao1_id` bigint(20) UNSIGNED NOT NULL,
  `decisao2_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `situacoes`
--

INSERT INTO `situacoes` (`id`, `nome`, `desc`, `carreira_id`, `decisao1_id`, `decisao2_id`, `created_at`, `updated_at`) VALUES
(3, 'Seu paciente chegou atrasado!', NULL, 2, 11, 12, '2025-11-19 06:18:09', '2025-11-19 06:18:09'),
(4, 'Poucos atendimentos...', NULL, 2, 8, 5, '2025-11-19 06:18:09', '2025-11-19 06:18:09'),
(5, 'Seu paciente está em crise!', NULL, 2, 6, 7, '2025-11-19 06:18:09', '2025-11-19 06:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'osakirii', 'sak.rimoon@gmail.com', 1, NULL, '$2y$12$.qJDJR9Ft/zv2mcya5Zo/u6nmGZbxnrmFaLsVLJd7TOBp6GfOSqG6', NULL, '2025-11-19 05:11:08', '2025-11-19 05:11:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carreiras`
--
ALTER TABLE `carreiras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartas`
--
ALTER TABLE `cartas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `historicos`
--
ALTER TABLE `historicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historicos_carreira_id_foreign` (`carreira_id`),
  ADD KEY `historicos_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `situacoes`
--
ALTER TABLE `situacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `situacoes_carreira_id_foreign` (`carreira_id`),
  ADD KEY `situacoes_decisao1_id_foreign` (`decisao1_id`),
  ADD KEY `situacoes_decisao2_id_foreign` (`decisao2_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carreiras`
--
ALTER TABLE `carreiras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cartas`
--
ALTER TABLE `cartas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historicos`
--
ALTER TABLE `historicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `situacoes`
--
ALTER TABLE `situacoes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historicos`
--
ALTER TABLE `historicos`
  ADD CONSTRAINT `historicos_carreira_id_foreign` FOREIGN KEY (`carreira_id`) REFERENCES `carreiras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historicos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `situacoes`
--
ALTER TABLE `situacoes`
  ADD CONSTRAINT `situacoes_carreira_id_foreign` FOREIGN KEY (`carreira_id`) REFERENCES `carreiras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `situacoes_decisao1_id_foreign` FOREIGN KEY (`decisao1_id`) REFERENCES `cartas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `situacoes_decisao2_id_foreign` FOREIGN KEY (`decisao2_id`) REFERENCES `cartas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

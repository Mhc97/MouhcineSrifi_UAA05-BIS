CREATE DATABASE IF NOT EXISTS `mouhcine_cfitech`
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `mouhcine_cfitech`;

-- ── TABLE formations ────────────────────────
DROP TABLE IF EXISTS `stagiaires`;
DROP TABLE IF EXISTS `formations`;
DROP TABLE IF EXISTS `personnel`;

CREATE TABLE `formations` (
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `intitule`   VARCHAR(100) NOT NULL,
    `nb_mois`    INT          NOT NULL,
    `date_debut` DATE         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── TABLE stagiaires ────────────────────────
CREATE TABLE `stagiaires` (
    `id`             INT AUTO_INCREMENT PRIMARY KEY,
    `nom`            VARCHAR(100) NOT NULL,
    `prenom`         VARCHAR(100) NOT NULL,
    `email`          VARCHAR(100) NOT NULL UNIQUE,
    `date_naissance` DATE         NOT NULL,
    `formation_id`   INT          NOT NULL,
    FOREIGN KEY (`formation_id`) REFERENCES `formations`(`id`)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ── TABLE personnel ─────────────────────────
CREATE TABLE `personnel` (
    `id`            INT AUTO_INCREMENT PRIMARY KEY,
    `login`         VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- DONNÉES
-- ============================================

-- Formations
INSERT INTO `formations` (`intitule`, `nb_mois`, `date_debut`) VALUES
('Web Dev',    12, '2026-01-05'),
('Technicien', 11, '2025-08-25'),
('Java Dev',    7, '2025-09-01');

-- Personnel (mot de passe : admin123)
-- Pour regénérer : ouvrir creer_admin.php dans le navigateur
INSERT INTO `personnel` (`login`, `password_hash`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
-- ⚠️ IMPORTANT : après import, ouvrir creer_admin.php pour regénérer le hash !

-- Stagiaires – Web Dev (id=1)
INSERT INTO `stagiaires` (`nom`, `prenom`, `email`, `date_naissance`, `formation_id`) VALUES
('Srifi',    'Mouhcine', 'mouhcine.srifi@cfitech.be', '2000-01-01', 1),
('Dupont',   'Marie',    'marie.dupont@test.com',      '1998-03-15', 1),
('Martin',   'Lucas',    'lucas.martin@test.com',      '1999-07-22', 1);

-- Stagiaires – Technicien (id=2)
INSERT INTO `stagiaires` (`nom`, `prenom`, `email`, `date_naissance`, `formation_id`) VALUES
('Julien',   'Dunia',   'jdunia@cfitech.be',     '2000-04-11', 2),
('Bernard',  'Sophie',  'sophie.b@test.com',      '2001-05-30', 2),
('Leroy',    'Thomas',  'thomas.leroy@test.com',  '1997-11-09', 2);

-- Stagiaires – Java Dev (id=3)
INSERT INTO `stagiaires` (`nom`, `prenom`, `email`, `date_naissance`, `formation_id`) VALUES
('Moreau',   'Julie',   'julie.moreau@test.com',  '2000-08-18', 3),
('Petit',    'Antoine', 'antoine.petit@test.com', '1999-02-28', 3),
('Simon',    'Laura',   'laura.simon@test.com',   '2001-12-05', 3);

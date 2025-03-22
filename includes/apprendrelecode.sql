-- Création de la base de données
CREATE DATABASE IF NOT EXISTS metmaticom;
USE metmaticom;

-- Désactivation des vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Suppression des tables existantes dans l'ordre inverse des dépendances
DROP TABLE IF EXISTS videoProgress;
DROP TABLE IF EXISTS videos;
DROP TABLE IF EXISTS entities;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Réactivation des vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;

-- Table des utilisateurs
CREATE TABLE users (
    pseudo VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (pseudo)
);

-- Table des catégories (utilisée par les entités)
CREATE TABLE categories (
    id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    PRIMARY KEY (id)
);

-- Table des entités (films, séries, etc.)
CREATE TABLE entities (
    id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    preview VARCHAR(255),
    thumbnail VARCHAR(255),
    categoryId INT,
    slug VARCHAR(255),
    PRIMARY KEY (id),
    CONSTRAINT fk_entities_category
        FOREIGN KEY (categoryId) REFERENCES categories(id)
        ON DELETE SET NULL
);

-- Table des vidéos
CREATE TABLE videos (
    id INT AUTO_INCREMENT NOT NULL,
    entityId INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    duration INT,
    isMovie BOOLEAN DEFAULT 0,
    season INT DEFAULT 0,
    episode INT DEFAULT 0,
    slugVideo VARCHAR(255),
    PRIMARY KEY (id),
    CONSTRAINT fk_videos_entity
        FOREIGN KEY (entityId) REFERENCES entities(id)
        ON DELETE CASCADE
);

-- Table de suivi de la progression des vidéos
CREATE TABLE videoProgress (
    pseudo VARCHAR(50) NOT NULL,
    videoId INT NOT NULL,
    progress INT DEFAULT 0,
    finished BOOLEAN DEFAULT 0,
    dateModified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (pseudo, videoId),
    CONSTRAINT fk_videoProgress_user
        FOREIGN KEY (pseudo) REFERENCES users(pseudo)
        ON DELETE CASCADE,
    CONSTRAINT fk_videoProgress_video
        FOREIGN KEY (videoId) REFERENCES videos(id)
        ON DELETE CASCADE
);
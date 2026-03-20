-- =======================================================
-- FLASHCAR DATABASE — Full SQL Schema
-- Run this in phpMyAdmin or MySQL Workbench
-- =======================================================

-- Step 1: Create & use the database
CREATE DATABASE IF NOT EXISTS flashcar_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE flashcar_db;

-- =======================================================
-- Table: users
-- =======================================================
CREATE TABLE IF NOT EXISTS users (
    id               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name             VARCHAR(255)    NOT NULL,
    email            VARCHAR(255)    NOT NULL UNIQUE,
    email_verified_at TIMESTAMP      NULL     DEFAULT NULL,
    password         VARCHAR(255)    NOT NULL,
    remember_token   VARCHAR(100)    NULL     DEFAULT NULL,
    created_at       TIMESTAMP       NULL     DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP       NULL     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =======================================================
-- Table: languages
-- =======================================================
CREATE TABLE IF NOT EXISTS languages (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name        VARCHAR(255)    NOT NULL,
    code        VARCHAR(10)     NOT NULL,
    flag_emoji  VARCHAR(10)     NULL DEFAULT NULL,
    created_at  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =======================================================
-- Table: decks
-- =======================================================
CREATE TABLE IF NOT EXISTS decks (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id     BIGINT UNSIGNED NOT NULL,
    language_id BIGINT UNSIGNED NOT NULL,
    title       VARCHAR(255)    NOT NULL,
    description TEXT            NULL DEFAULT NULL,
    color       VARCHAR(7)      NOT NULL DEFAULT '#4F46E5',
    created_at  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_user_id     (user_id),
    INDEX idx_language_id (language_id),
    CONSTRAINT fk_decks_user     FOREIGN KEY (user_id)     REFERENCES users(id)     ON DELETE CASCADE,
    CONSTRAINT fk_decks_language FOREIGN KEY (language_id) REFERENCES languages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =======================================================
-- Table: cards
-- =======================================================
CREATE TABLE IF NOT EXISTS cards (
    id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    deck_id     BIGINT UNSIGNED NOT NULL,
    front       VARCHAR(255)    NOT NULL,
    back        TEXT            NOT NULL,
    `order`     INT             NOT NULL DEFAULT 0,
    created_at  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP       NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_deck_id (deck_id),
    CONSTRAINT fk_cards_deck FOREIGN KEY (deck_id) REFERENCES decks(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =======================================================
-- Laravel required tables: sessions, cache, jobs
-- (Only needed if using database session/cache driver)
-- =======================================================
CREATE TABLE IF NOT EXISTS sessions (
    id            VARCHAR(255)    NOT NULL,
    user_id       BIGINT UNSIGNED NULL,
    ip_address    VARCHAR(45)     NULL,
    user_agent    TEXT            NULL,
    payload       LONGTEXT        NOT NULL,
    last_activity INT             NOT NULL,
    PRIMARY KEY (id),
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cache (
    `key`       VARCHAR(255) NOT NULL,
    value       MEDIUMTEXT   NOT NULL,
    expiration  INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cache_locks (
    `key`       VARCHAR(255) NOT NULL,
    owner       VARCHAR(255) NOT NULL,
    expiration  INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =======================================================
-- Seed: Default Languages
-- =======================================================
INSERT INTO languages (name, code, flag_emoji) VALUES
    ('English',    'en', '🇺🇸'),
    ('Vietnamese', 'vi', '🇻🇳'),
    ('Japanese',   'ja', '🇯🇵'),
    ('Korean',     'ko', '🇰🇷'),
    ('French',     'fr', '🇫🇷'),
    ('Chinese',    'zh', '🇨🇳'),
    ('Spanish',    'es', '🇪🇸'),
    ('German',     'de', '🇩🇪')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- =======================================================
-- Seed: Sample User (password = "password")
-- =======================================================
INSERT INTO users (name, email, password) VALUES
    ('Nguyen Xuan Duong', 'duong@example.com',
     '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- =======================================================
-- Seed: Sample Decks & Cards
-- =======================================================
SET @uid = (SELECT id FROM users WHERE email = 'duong@example.com' LIMIT 1);
SET @en  = (SELECT id FROM languages WHERE code = 'en' LIMIT 1);
SET @vi  = (SELECT id FROM languages WHERE code = 'vi' LIMIT 1);

INSERT INTO decks (user_id, language_id, title, description, color) VALUES
    (@uid, @en, 'Basic English Vocabulary', 'Essential English words for everyday communication.', '#4F46E5'),
    (@uid, @vi, 'Từ Vựng Tiếng Việt',       'Các từ vựng tiếng Việt quan trọng.',                  '#8B5CF6');

SET @deck1 = (SELECT id FROM decks WHERE title = 'Basic English Vocabulary' LIMIT 1);
SET @deck2 = (SELECT id FROM decks WHERE title = 'Từ Vựng Tiếng Việt' LIMIT 1);

INSERT INTO cards (deck_id, front, back, `order`) VALUES
    (@deck1, 'Ubiquitous', 'Present, appearing, or found everywhere.', 1),
    (@deck1, 'Ephemeral',  'Lasting for a very short time.',           2),
    (@deck1, 'Pragmatic',  'Dealing with things sensibly and realistically.', 3),
    (@deck1, 'Eloquent',   'Fluent or persuasive in speaking or writing.', 4),
    (@deck1, 'Resilient',  'Able to recover quickly from difficulties.', 5),
    (@deck2, 'Hạnh phúc', 'Happiness - trạng thái vui vẻ, mãn nguyện.', 1),
    (@deck2, 'Kiên trì',  'Perseverance - không bỏ cuộc trước khó khăn.', 2),
    (@deck2, 'Sáng tạo',  'Creative - khả năng tạo ra cái mới.', 3),
    (@deck2, 'Tri thức',  'Knowledge - hiểu biết thu được qua học tập.', 4);

-- Done!
SELECT 'Flashcar database setup complete! ✅' AS status;

CREATE DATABASE IF NOT EXISTS klesarstvo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE klesarstvo;

DROP TABLE IF EXISTS request_items;
DROP TABLE IF EXISTS requests;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS works;
DROP TABLE IF EXISTS stone_types;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE stone_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  image VARCHAR(255)
);

CREATE TABLE works (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  image VARCHAR(255),
  stone_type_id INT NOT NULL,
  FOREIGN KEY (stone_type_id) REFERENCES stone_types(id) ON DELETE CASCADE
);

CREATE TABLE requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  full_name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  status ENUM('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE request_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT NOT NULL,
  stone_type_id INT NOT NULL,
  product VARCHAR(50) NOT NULL,
  length_cm INT NOT NULL,
  width_cm INT NOT NULL,
  height_cm INT NOT NULL,
  engraving_text TEXT,
  FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE,
  FOREIGN KEY (stone_type_id) REFERENCES stone_types(id) ON DELETE CASCADE
);

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  rating TINYINT NOT NULL,
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample data (placeholder hash;treba i ovo)
INSERT INTO users (name, email, password_hash, role) VALUES
('Admin Musanovic', 'admin@klesarstvo.ba', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCZQ4hQ3fN9uKq5nZ2d8s3x6VQe5K', 'admin'),
('Test Korisnik', 'user@klesarstvo.ba', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCZQ4hQ3fN9uKq5nZ2d8s3x6VQe5K', 'user'),
('Amra Hodzic', 'amra@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCZQ4hQ3fN9uKq5nZ2d8s3x6VQe5K', 'user');

INSERT INTO stone_types (name, description, image) VALUES
('Granit', 'Vrlo čvrst, dugotrajan.', 'stepenice-granit.jpg'),
('Mramor', 'Svijetao, fina obrada.', 'stepenice-mramor.jpg'),
('Krečnjak', 'Prirodan izgled.', 'stepenice-krecnjak.jpg'),
('Crni granit', 'Taman i sjajan.', 'stepenice-crni-granit.jpg'),
('Pješčenjak', 'Topla boja, lakši za obradu.', NULL);

INSERT INTO works (title, description, image, stone_type_id) VALUES
('Stepenice od granita', 'Vanjski ulaz od sivog granita.', 'stepenice-granit.jpg', 1),
('Moderne stepenice', 'Poliran crni granit.', 'stepenice-crni-granit.jpg', 4),
('Vanjski kamin', 'Kamin od prirodnog kamena.', 'kamin.jpg', 3),
('Nišan od mramora', 'Ručno klesan natpis.', 'nisan-mramor.jpg', 2),
('Tradicionalni spomenik', 'Mramorni spomenik.', 'spomenik-stari.jpg', 2);

INSERT INTO requests (user_id, full_name, phone, status) VALUES
(2, 'Test Korisnik', '061111222', 'pending'),
(3, 'Amra Hodzic', '062333444', 'approved'),
(NULL, 'Gost Posjetilac', '063555666', 'pending');

INSERT INTO request_items (request_id, stone_type_id, product, length_cm, width_cm, height_cm, engraving_text) VALUES
(1, 1, 'Stepenice', 120, 30, 15, NULL),
(1, 4, 'Stepenice', 120, 30, 15, NULL),
(2, 2, 'Nišan', 100, 40, 15, 'Ime i prezime'),
(3, 3, 'Kamin', 150, 60, 200, NULL);

INSERT INTO reviews (user_id, rating, comment) VALUES
(2, 5, 'Odličan rad i brza isporuka.'),
(3, 4, 'Vrlo zadovoljna, preporuka.');
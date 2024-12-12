
CREATE DATABASE theater;

USE theater;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user', 'actor', 'director') DEFAULT 'user', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,  -- кто написал новость
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);


INSERT INTO users (username, password, email, role) 
VALUES 
('admin', '$2y$10$ldBMHDMQF/gpfnXnm7lfQ.tk4DK69PNr9qP4Yi9CjWQHU.H0wIa12', 'admin@example.com', 'admin');


INSERT INTO posts (title, content, author_id) 
VALUES 
('Новая постановка: "Макбет" на сцене Театра X', 'Театр X представляет новую постановку "Макбет". Режиссёр — Иван Иванов.', 1),
('Представление для детей: "Щелкунчик"', 'В театре Y открыта новая детская постановка "Щелкунчик".', 1);


SELECT p.title, p.content, u.username AS author, p.created_at 
FROM posts p 
JOIN users u ON p.author_id = u.id 
ORDER BY p.created_at DESC;

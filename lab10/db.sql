
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    username VARCHAR(50) NOT NULL UNIQUE,  
    password VARCHAR(255) NOT NULL,  
    email VARCHAR(100) NOT NULL UNIQUE,  
    role ENUM('admin', 'user') DEFAULT 'user',  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
);


CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    title VARCHAR(255) NOT NULL,  
    content TEXT NOT NULL,  
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE  
);


INSERT INTO users (username, password, email, role) 
VALUES 
('admin', '$2y$10$ldBMHDMQF/gpfnXnm7lfQ.tk4DK69PNr9qP4Yi9CjWQHU.H0wIa12', 'admin@example.com', 'admin');


INSERT INTO users (username, password, email, role) 
VALUES 
('user1', '$2y$10$somehashedpassword1', 'user1@example.com', 'user'),
('user2', '$2y$10$somehashedpassword2', 'user2@example.com', 'user');


INSERT INTO articles (title, content, author_id) 
VALUES 
('Добро пожаловать в театр!', 'Новости театра, самые ожидаемые премьеры и события!', 1),
('Роль главного героя в спектакле', 'Как подготовиться к роли главного героя в спектакле?', 1),
('Анонс спектакля "Ромео и Джульетта"', 'Скоро в нашем театре состоится премьера спектакля "Ромео и Джульетта".', 1),
('Как стать актером: советы новичкам', 'Начать карьеру в театре может каждый! Подробности внутри.', 2);


SELECT a.title, a.content, u.username AS author, a.created_at 
FROM articles a 
JOIN users u ON a.author_id = u.id 
ORDER BY a.created_at DESC;


SELECT a.title, a.content, u.username AS author, a.created_at 
FROM articles a 
JOIN users u ON a.author_id = u.id 
WHERE u.role IN ('admin', 'user')  
ORDER BY a.created_at DESC;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admins;
  

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    ville VARCHAR(50)
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, email, password, ville) VALUES
('admin', 'admin@none.com', '$2y$10$NX4AjvEr2TSvwNdpTlIbDOhaL01MbyLdolXoIBKuXgdV7X1r71T5a', NULL),
('test', 'test@test.com', '$2y$10$suYXvxKOFeT1Lb1PgSSst.k.93GFppZzpNGQ0RWEYVBs0Gsy.4eDO', 'Paris');

INSERT INTO admins (user_id) VALUES
(1);

INSERT INTO contacts (name, email, message) VALUES
('John Jones', 'john@example.com', 'Ceci est un test');

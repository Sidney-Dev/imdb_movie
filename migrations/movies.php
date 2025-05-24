<?php

use Core\Database;

return function (PDO $pdo) {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS movies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
            plot TEXT,
            poster TEXT,
            rating VARCHAR(10),
            released DATE,
            imdb_id VARCHAR(50) UNIQUE,
            movie_code VARCHAR(10),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
};

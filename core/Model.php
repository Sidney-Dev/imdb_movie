<?php

namespace Core;

use PDO;

abstract class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->pdo->prepare("INSERT INTO {$table} ($columns) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function exists(string $table, string $column, $value): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        return $stmt->fetchColumn() > 0;
    }
}

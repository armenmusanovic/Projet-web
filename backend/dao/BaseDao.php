<?php
require_once __DIR__ . '/Database.php';

class BaseDao
{
    protected PDO $connection;
    protected string $table;

    public function __construct(string $table)
    {
        $this->connection = Database::connect();
        $this->table = $table;
    }

    public function getAll(): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $stmt = $this->connection->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $stmt->execute($data);
        return (int) $this->connection->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        foreach (array_keys($data) as $column) {
            $fields[] = "$column = :$column";
        }
        $data['id'] = $id;
        $stmt = $this->connection->prepare("UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
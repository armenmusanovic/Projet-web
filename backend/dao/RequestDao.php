<?php
require_once __DIR__ . '/BaseDao.php';

class RequestDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('requests');
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM requests WHERE user_id = :id ORDER BY created_at DESC");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchAll();
    }
}
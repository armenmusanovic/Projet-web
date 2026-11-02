<?php
require_once __DIR__ . '/BaseDao.php';

class RequestItemDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('request_items');
    }

    public function getByRequest(int $requestId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM request_items WHERE request_id = :id");
        $stmt->execute(['id' => $requestId]);
        return $stmt->fetchAll();
    }
}
<?php
require_once __DIR__ . '/BaseDao.php';

class ReviewDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('reviews');
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM reviews WHERE user_id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchAll();
    }
}
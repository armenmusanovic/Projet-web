<?php
require_once __DIR__ . '/BaseDao.php';

class WorkDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('works');
    }

    public function getByStoneType(int $stoneTypeId): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM works WHERE stone_type_id = :id");
        $stmt->execute(['id' => $stoneTypeId]);
        return $stmt->fetchAll();
    }
}


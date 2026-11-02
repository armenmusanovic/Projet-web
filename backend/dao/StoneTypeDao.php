<?php
require_once __DIR__ . '/BaseDao.php';

class StoneTypeDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('stone_types');
    }
}
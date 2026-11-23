<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/StoneTypeDao.php';

class StoneTypeService extends BaseService
{
    protected array $fields = ['name', 'description', 'image'];

    public function __construct()
    {
        parent::__construct(new StoneTypeDao());
    }

    protected function validate(array $data, bool $isCreate): void
    {
        if ($isCreate) {
            $this->requireFields($data, ['name']);
        }
        if (isset($data['name']) && strlen(trim($data['name'])) > 100) {
            throw new ValidationException('Name must be at most 100 characters');
        }
    }
}
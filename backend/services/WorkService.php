<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/StoneTypeService.php';
require_once __DIR__ . '/../dao/WorkDao.php';

class WorkService extends BaseService
{
    protected array $fields = ['title', 'description', 'image', 'stone_type_id'];

    public function __construct()
    {
        parent::__construct(new WorkDao());
    }

    protected function validate(array $data, bool $isCreate): void
    {
        if ($isCreate) {
            $this->requireFields($data, ['title', 'stone_type_id']);
        }
        if (isset($data['title']) && strlen(trim($data['title'])) > 150) {
            throw new ValidationException('Title must be at most 150 characters');
        }
        if (isset($data['stone_type_id'])) {
            if (filter_var($data['stone_type_id'], FILTER_VALIDATE_INT) === false) {
                throw new ValidationException('stone_type_id must be an integer');
            }
            try {
                (new StoneTypeService())->getById((int) $data['stone_type_id']);
            } catch (NotFoundException $e) {
                throw new ValidationException('Stone type does not exist');
            }
        }
    }
}
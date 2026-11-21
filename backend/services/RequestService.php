<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/UserService.php';
require_once __DIR__ . '/../dao/RequestDao.php';

class RequestService extends BaseService
{
    private const STATUSES = ['pending', 'approved', 'rejected', 'completed'];

    protected array $fields = ['user_id', 'full_name', 'phone', 'status'];

    public function __construct()
    {
        parent::__construct(new RequestDao());
    }

    // Novi zahtjev uvijek počinje kao 'pending'
    public function create(array $data): array
    {
        unset($data['status']);
        return parent::create($data);
    }

    protected function validate(array $data, bool $isCreate): void
    {
        if ($isCreate) {
            $this->requireFields($data, ['full_name', 'phone']);
        }
        if (isset($data['full_name']) && strlen(trim($data['full_name'])) > 100) {
            throw new ValidationException('Full name must be at most 100 characters');
        }
        if (isset($data['phone']) && !preg_match('/^[0-9+\/\s-]{6,30}$/', $data['phone'])) {
            throw new ValidationException('Invalid phone number');
        }
        if (isset($data['status']) && !in_array($data['status'], self::STATUSES, true)) {
            throw new ValidationException('Status must be one of: ' . implode(', ', self::STATUSES));
        }
        if (isset($data['user_id'])) {
            if (filter_var($data['user_id'], FILTER_VALIDATE_INT) === false) {
                throw new ValidationException('user_id must be an integer');
            }
            try {
                (new UserService())->getById((int) $data['user_id']);
            } catch (NotFoundException $e) {
                throw new ValidationException('User does not exist');
            }
        }
    }
}
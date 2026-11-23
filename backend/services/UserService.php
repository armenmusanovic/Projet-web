<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

class UserService extends BaseService
{
    protected array $fields = ['name', 'email', 'password', 'role'];

    public function __construct()
    {
        parent::__construct(new UserDao());
    }

    public function create(array $data): array
    {
        $clean = $this->filter($data);
        $this->validate($clean, true);
        return $this->save($clean, null);
    }

    public function update(int $id, array $data): array
    {
        $this->getById($id);
        $clean = $this->filter($data);
        if (empty($clean)) {
            throw new ValidationException('No valid fields to update');
        }
        $this->validate($clean, false);
        return $this->save($clean, $id);
    }

    // Pretvara 'password' u 'password_hash' i provjerava jedinstvenost emaila
    private function save(array $clean, ?int $id): array
    {
        if (isset($clean['email'])) {
            $existing = $this->dao->getByEmail($clean['email']);
            if ($existing !== null && $existing['id'] !== $id) {
                throw new ValidationException('Email is already in use');
            }
        }
        if (isset($clean['password'])) {
            $clean['password_hash'] = password_hash($clean['password'], PASSWORD_DEFAULT);
            unset($clean['password']);
        }
        if ($id === null) {
            $id = $this->dao->create($clean);
        } else {
            $this->dao->update($id, $clean);
        }
        return $this->getById($id);
    }

    // Lozinka (hash) se nikad ne vraća klijentu
    public function getAll(): array
    {
        return array_map([$this, 'hideHash'], parent::getAll());
    }

    public function getById(int $id): array
    {
        return $this->hideHash(parent::getById($id));
    }

    private function hideHash(array $user): array
    {
        unset($user['password_hash']);
        return $user;
    }

    protected function validate(array $data, bool $isCreate): void
    {
        if ($isCreate) {
            $this->requireFields($data, ['name', 'email', 'password']);
        }
        if (isset($data['name']) && strlen(trim($data['name'])) > 100) {
            throw new ValidationException('Name must be at most 100 characters');
        }
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('Invalid email format');
        }
        if (isset($data['password']) && strlen($data['password']) < 6) {
            throw new ValidationException('Password must be at least 6 characters');
        }
        if (isset($data['role']) && !in_array($data['role'], ['admin', 'user'], true)) {
            throw new ValidationException("Role must be 'admin' or 'user'");
        }
    }
}

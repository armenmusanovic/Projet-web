<?php
require_once __DIR__ . '/Exceptions.php';

abstract class BaseService
{
    protected $dao;
    protected array $fields = []; // dozvoljena polja

    public function __construct($dao)
    {
        $this->dao = $dao;
    }

    public function getAll(): array
    {
        return $this->dao->getAll();
    }

    public function getById(int $id): array
    {
        $row = $this->dao->getById($id);
        if ($row === null) {
            throw new NotFoundException('Record not found');
        }
        return $row;
    }

    public function create(array $data): array
    {
        $clean = $this->filter($data);
        $this->validate($clean, true);
        $id = $this->dao->create($clean);
        return $this->getById($id);
    }

    public function update(int $id, array $data): array
    {
        $this->getById($id); // baca 404 ako ne postoji
        $clean = $this->filter($data);
        if (empty($clean)) {
            throw new ValidationException('No valid fields to update');
        }
        $this->validate($clean, false);
        $this->dao->update($id, $clean);
        return $this->getById($id);
    }

    public function delete(int $id): void
    {
        $this->getById($id);
        $this->dao->delete($id);
    }

    // Propušta samo polja iz $fields
    protected function filter(array $data): array
    {
        return array_intersect_key($data, array_flip($this->fields));
    }

    protected function requireFields(array $data, array $required): void
    {
        foreach ($required as $field) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                throw new ValidationException("Field '$field' is required");
            }
        }
    }

    abstract protected function validate(array $data, bool $isCreate): void;
}
<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/RequestService.php';
require_once __DIR__ . '/StoneTypeService.php';
require_once __DIR__ . '/../dao/RequestItemDao.php';

class RequestItemService extends BaseService
{
    private const PRODUCTS = ['Stepenice', 'Klupica', 'Nišan', 'Spomenik', 'Kamin', 'Ostalo'];

    protected array $fields = [
        'request_id', 'stone_type_id', 'product',
        'length_cm', 'width_cm', 'height_cm', 'engraving_text'
    ];

    public function __construct()
    {
        parent::__construct(new RequestItemDao());
    }

    protected function validate(array $data, bool $isCreate): void
    {
        if ($isCreate) {
            $this->requireFields($data, [
                'request_id', 'stone_type_id', 'product',
                'length_cm', 'width_cm', 'height_cm'
            ]);
        }
        if (isset($data['product']) && !in_array($data['product'], self::PRODUCTS, true)) {
            throw new ValidationException('Product must be one of: ' . implode(', ', self::PRODUCTS));
        }
        foreach (['length_cm', 'width_cm', 'height_cm'] as $dim) {
            if (isset($data[$dim])) {
                $value = filter_var($data[$dim], FILTER_VALIDATE_INT);
                if ($value === false || $value < 1) {
                    throw new ValidationException("$dim must be an integer greater than 0");
                }
            }
        }
        if (isset($data['request_id'])) {
            $this->requireExisting($data['request_id'], 'request_id', new RequestService(), 'Request');
        }
        if (isset($data['stone_type_id'])) {
            $this->requireExisting($data['stone_type_id'], 'stone_type_id', new StoneTypeService(), 'Stone type');
        }
    }

    // Provjerava da je vrijednost cijeli broj i da zapis postoji
    private function requireExisting($value, string $field, BaseService $service, string $label): void
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw new ValidationException("$field must be an integer");
        }
        try {
            $service->getById((int) $value);
        } catch (NotFoundException $e) {
            throw new ValidationException("$label does not exist");
        }
    }
}
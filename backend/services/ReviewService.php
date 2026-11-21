<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/UserService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class ReviewService extends BaseService
{
    protected array $fields = ['user_id', 'rating', 'comment'];

    public function __construct()
    {
        parent::__construct(new ReviewDao());
    }

    protected function validate(array $data, bool $isCreate): void
    {
        if ($isCreate) {
            $this->requireFields($data, ['user_id', 'rating']);
        }
        if (isset($data['rating'])) {
            $rating = filter_var($data['rating'], FILTER_VALIDATE_INT);
            if ($rating === false || $rating < 1 || $rating > 5) {
                throw new ValidationException('Rating must be an integer from 1 to 5');
            }
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

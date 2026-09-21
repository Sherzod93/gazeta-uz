<?php

declare(strict_types=1);

namespace App\Categories;

use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Query\Query;

final readonly class CategoryRepository
{
    public function __construct(
        private ConnectionInterface $db,
    ) {}

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        $rows = (new Query($this->db))
            ->from('categories')
            ->orderBy(['id' => SORT_ASC])
            ->all();

        return array_map(Category::fromArray(...), $rows);
    }

    public function findById(int $id): ?Category
    {
        $row = (new Query($this->db))
            ->from('categories')
            ->where(['id' => $id])
            ->one();

        return $row === null ? null : Category::fromArray($row);
    }

    public function findBySlug(string $slug): ?Category
    {
        $row = (new Query($this->db))
            ->from('categories')
            ->where(['slug' => $slug])
            ->one();

        return $row === null ? null : Category::fromArray($row);
    }
}

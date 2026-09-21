<?php

declare(strict_types=1);

namespace App\News;

use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Query\Query;

final readonly class NewsRepository
{
    public function __construct(
        private ConnectionInterface $db,
    ) {}

    /**
     * @return News[]
     */
    public function findLatest(int $limit = 20): array
    {
        $rows = (new Query($this->db))
            ->from('news')
            ->orderBy(['published_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        return array_map(News::fromArray(...), $rows);
    }

    public function findBySlug(string $slug): ?News
    {
        $row = (new Query($this->db))
            ->from('news')
            ->where(['slug' => $slug])
            ->one();

        return $row === null ? null : News::fromArray($row);
    }

    /**
     * @return News[]
     */
    public function findByCategory(int $categoryId, int $limit = 20): array
    {
        $rows = (new Query($this->db))
            ->from('news')
            ->where(['category_id' => $categoryId])
            ->orderBy(['published_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        return array_map(News::fromArray(...), $rows);
    }
}

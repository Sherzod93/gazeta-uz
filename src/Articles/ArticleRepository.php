<?php

declare(strict_types=1);

namespace App\Articles;

use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Query\Query;

final readonly class ArticleRepository
{
    public function __construct(
        private ConnectionInterface $db,
    ) {}

    /**
     * @return Article[]
     */
    public function findLatest(int $limit = 20): array
    {
        $rows = (new Query($this->db))
            ->from('articles')
            ->orderBy(['published_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        return array_map(Article::fromArray(...), $rows);
    }

    public function findBySlug(string $slug): ?Article
    {
        $row = (new Query($this->db))
            ->from('articles')
            ->where(['slug' => $slug])
            ->one();

        return $row === null ? null : Article::fromArray($row);
    }

    /**
     * @return Article[]
     */
    public function findByCategory(int $categoryId, int $limit = 20): array
    {
        $rows = (new Query($this->db))
            ->from('articles')
            ->where(['category_id' => $categoryId])
            ->orderBy(['published_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        return array_map(Article::fromArray(...), $rows);
    }
}

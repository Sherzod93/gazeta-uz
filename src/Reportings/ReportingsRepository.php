<?php

declare(strict_types=1);

namespace App\Reportings;

use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Query\Query;

final readonly class ReportingsRepository
{
    public function __construct(
        private ConnectionInterface $db,
    ) {}

    /**
     * @return Reportings[]
     */
    public function findLatest(int $limit = 20): array
    {
        $rows = (new Query($this->db))
            ->from('reportings')
            ->orderBy(['published_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        return array_map(Reportings::fromArray(...), $rows);
    }

    public function findBySlug(string $slug): ?Reportings
    {
        $row = (new Query($this->db))
            ->from('reportings')
            ->where(['slug' => $slug])
            ->one();

        return $row === null ? null : Reportings::fromArray($row);
    }

    /**
     * @return Reportings[]
     */
    public function findByCategory(int $categoryId, int $limit = 20): array
    {
        $rows = (new Query($this->db))
            ->from('reportings')
            ->where(['category_id' => $categoryId])
            ->orderBy(['published_at' => SORT_DESC])
            ->limit($limit)
            ->all();

        return array_map(Reportings::fromArray(...), $rows);
    }
}

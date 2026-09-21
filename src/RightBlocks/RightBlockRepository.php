<?php

declare(strict_types=1);

namespace App\RightBlocks;

use DateTimeImmutable;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Query\Query;

final readonly class RightBlockRepository
{
    public function __construct(
        private ConnectionInterface $db,
    ) {}

    /**
     * @return RightBlock[]
     */
    public function findAll(): array
    {
        $rows = (new Query($this->db))
            ->from('right_blocks')
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return array_map(RightBlock::fromArray(...), $rows);
    }

    public function findById(int $id): ?RightBlock
    {
        $row = (new Query($this->db))
            ->from('right_blocks')
            ->where(['id' => $id])
            ->one();

        return $row === null ? null : RightBlock::fromArray($row);
    }

    /**
     * Picks a promo block at random from the admin-managed list, used to vary the right-side block shown on every page load.
     */
    public function findRandom(): ?RightBlock
    {
        $rows = $this->findAll();

        return $rows === [] ? null : $rows[array_rand($rows)];
    }

    public function insert(RightBlockInput $input): int
    {
        $now = new DateTimeImmutable();

        $pk = $this->db->createCommand()->insertReturningPks('right_blocks', [
            ...$this->columns($input),
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s'),
        ]);

        return (int) $pk['id'];
    }

    public function update(int $id, RightBlockInput $input): void
    {
        $this->db->createCommand()
            ->update('right_blocks', [
                ...$this->columns($input),
                'updated_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ], ['id' => $id])
            ->execute();
    }

    public function delete(int $id): void
    {
        $this->db->createCommand()->delete('right_blocks', ['id' => $id])->execute();
    }

    /**
     * @return array<string, mixed>
     */
    private function columns(RightBlockInput $input): array
    {
        return [
            'logo' => $input->logo,
            'background_image' => $input->backgroundImage,
            'title' => $input->title,
            'subtitle' => $input->subtitle,
            'cta_text' => $input->ctaText,
            'cta_href' => $input->ctaHref,
        ];
    }
}

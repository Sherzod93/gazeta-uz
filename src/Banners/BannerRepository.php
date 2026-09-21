<?php

declare(strict_types=1);

namespace App\Banners;

use DateTimeImmutable;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Query\Query;

final readonly class BannerRepository
{
    public function __construct(
        private ConnectionInterface $db,
    ) {}

    /**
     * @return Banner[]
     */
    public function findAll(): array
    {
        $rows = (new Query($this->db))
            ->from('banners')
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return array_map(Banner::fromArray(...), $rows);
    }

    public function findById(int $id): ?Banner
    {
        $row = (new Query($this->db))
            ->from('banners')
            ->where(['id' => $id])
            ->one();

        return $row === null ? null : Banner::fromArray($row);
    }

    /**
     * Picks a banner at random from the admin-managed list, used to vary the banner shown on every page load.
     */
    public function findRandom(): ?Banner
    {
        $rows = $this->findAll();

        return $rows === [] ? null : $rows[array_rand($rows)];
    }

    public function insert(BannerInput $input): int
    {
        $now = new DateTimeImmutable();

        $pk = $this->db->createCommand()->insertReturningPks('banners', [
            ...$this->columns($input),
            'created_at' => $now->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s'),
        ]);

        return (int) $pk['id'];
    }

    public function update(int $id, BannerInput $input): void
    {
        $this->db->createCommand()
            ->update('banners', [
                ...$this->columns($input),
                'updated_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ], ['id' => $id])
            ->execute();
    }

    public function delete(int $id): void
    {
        $this->db->createCommand()->delete('banners', ['id' => $id])->execute();
    }

    /**
     * @return array<string, mixed>
     */
    private function columns(BannerInput $input): array
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

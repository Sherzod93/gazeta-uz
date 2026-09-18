<?php

declare(strict_types=1);

namespace App\Admin\Content;

use DateTimeImmutable;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Query\Query;

final readonly class ContentRepository
{
    public function __construct(
        private ConnectionInterface $db,
    ) {}

    /**
     * @return ContentItem[]
     */
    public function findAll(ContentType $type): array
    {
        $rows = (new Query($this->db))
            ->from($type->table())
            ->orderBy(['published_at' => SORT_DESC])
            ->all();

        return array_map(ContentItem::fromArray(...), $rows);
    }

    public function findById(ContentType $type, int $id): ?ContentItem
    {
        $row = (new Query($this->db))
            ->from($type->table())
            ->where(['id' => $id])
            ->one();

        return $row === null ? null : ContentItem::fromArray($row);
    }

    public function slugExists(ContentType $type, string $slug, ?int $excludeId = null): bool
    {
        $query = (new Query($this->db))
            ->from($type->table())
            ->where(['slug' => $slug]);

        if ($excludeId !== null) {
            $query->andWhere(['<>', 'id', $excludeId]);
        }

        return $query->exists();
    }

    public function insert(ContentType $type, ContentInput $input): int
    {
        $now = new DateTimeImmutable();

        $pk = $this->db->createCommand()->insertReturningPks($type->table(), [
            ...$this->columns($input, $now),
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);

        return (int) $pk['id'];
    }

    public function update(ContentType $type, int $id, ContentInput $input): void
    {
        $this->db->createCommand()
            ->update($type->table(), $this->columns($input, new DateTimeImmutable()), ['id' => $id])
            ->execute();
    }

    public function delete(ContentType $type, int $id): void
    {
        $this->db->createCommand()->delete($type->table(), ['id' => $id])->execute();
    }

    /**
     * @return array<string, mixed>
     */
    private function columns(ContentInput $input, DateTimeImmutable $now): array
    {
        $publishedAt = DateTimeImmutable::createFromFormat(ContentInput::DATETIME_FORMAT, $input->publishedAt) ?: $now;

        return [
            'title' => $input->title,
            'slug' => $input->slug,
            'summary' => $input->summary,
            'content' => $input->content,
            'image' => $input->image,
            'published_at' => $publishedAt->format('Y-m-d H:i:s'),
            'updated_at' => $now->format('Y-m-d H:i:s'),
        ];
    }
}

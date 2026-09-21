<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M260921100000CreateCategoriesTable implements RevertibleMigrationInterface
{
    private const NAMES = [
        'Политика',
        'Экономика',
        'Общество',
        'Культура',
        'Мир',
        'Колонки',
    ];

    public function up(MigrationBuilder $b): void
    {
        $b->createTable('categories', [
            'id' => ColumnBuilder::primaryKey(),
            'name' => ColumnBuilder::string(255)->notNull(),
            'slug' => ColumnBuilder::string(255)->notNull(),
        ]);

        $b->createIndex('categories', 'idx-categories-slug', 'slug', 'UNIQUE');

        foreach (self::NAMES as $name) {
            $b->insert('categories', [
                'name' => $name,
                'slug' => $this->slugify($name),
            ]);
        }
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('categories');
    }

    private function slugify(string $name): string
    {
        $map = [
            'Политика' => 'politika',
            'Экономика' => 'ekonomika',
            'Общество' => 'obshchestvo',
            'Культура' => 'kultura',
            'Мир' => 'mir',
            'Колонки' => 'kolonki',
        ];

        return $map[$name];
    }
}

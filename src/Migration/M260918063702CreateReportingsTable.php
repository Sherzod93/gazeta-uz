<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M260918063702CreateReportingsTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('reportings', [
            'id' => ColumnBuilder::primaryKey(),
            'title' => ColumnBuilder::string(255)->notNull(),
            'slug' => ColumnBuilder::string(255)->notNull(),
            'summary' => ColumnBuilder::text()->notNull(),
            'content' => ColumnBuilder::text()->notNull(),
            'image' => ColumnBuilder::string(255),
            'published_at' => ColumnBuilder::datetime()->notNull(),
            'created_at' => ColumnBuilder::datetime()->notNull(),
            'updated_at' => ColumnBuilder::datetime()->notNull(),
        ]);

        $b->createIndex('reportings', 'idx-reportings-slug', 'slug', 'UNIQUE');
        $b->createIndex('reportings', 'idx-reportings-published_at', 'published_at');
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('reportings');
    }
}

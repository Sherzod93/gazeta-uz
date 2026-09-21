<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M260921100100AddCategoryIdToContentTables implements RevertibleMigrationInterface
{
    private const TABLES = ['news', 'reportings', 'articles'];

    public function up(MigrationBuilder $b): void
    {
        foreach (self::TABLES as $table) {
            $b->addColumn($table, 'category_id', ColumnBuilder::integer());
            $b->createIndex($table, "idx-{$table}-category_id", 'category_id');
            $b->addForeignKey(
                $table,
                "fk-{$table}-category_id",
                'category_id',
                'categories',
                'id',
                'SET NULL',
            );
        }
    }

    public function down(MigrationBuilder $b): void
    {
        foreach (self::TABLES as $table) {
            $b->dropForeignKey($table, "fk-{$table}-category_id");
            $b->dropIndex($table, "idx-{$table}-category_id");
            $b->dropColumn($table, 'category_id');
        }
    }
}

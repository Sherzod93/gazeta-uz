<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M260921110100CreateRightBlocksTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->createTable('right_blocks', [
            'id' => ColumnBuilder::primaryKey(),
            'logo' => ColumnBuilder::string(255)->notNull(),
            'title' => ColumnBuilder::string(255)->notNull(),
            'subtitle' => ColumnBuilder::string(255),
            'cta_text' => ColumnBuilder::string(255),
            'cta_href' => ColumnBuilder::string(255),
            'created_at' => ColumnBuilder::datetime()->notNull(),
            'updated_at' => ColumnBuilder::datetime()->notNull(),
        ]);
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropTable('right_blocks');
    }
}

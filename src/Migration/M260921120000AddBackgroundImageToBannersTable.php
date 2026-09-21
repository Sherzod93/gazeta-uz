<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M260921120000AddBackgroundImageToBannersTable implements RevertibleMigrationInterface
{
    public function up(MigrationBuilder $b): void
    {
        $b->addColumn('banners', 'background_image', ColumnBuilder::string(255));
    }

    public function down(MigrationBuilder $b): void
    {
        $b->dropColumn('banners', 'background_image');
    }
}

<?php

declare(strict_types=1);

namespace App\Admin\Content;

use Psr\Http\Message\UploadedFileInterface;
use Yiisoft\Aliases\Aliases;

use const UPLOAD_ERR_NO_FILE;
use const UPLOAD_ERR_OK;

final readonly class ContentImageUploader
{
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    public function __construct(
        private Aliases $aliases,
    ) {}

    /**
     * @return string|null Web-accessible path of the stored image, or null if no file was uploaded.
     *
     * @throws InvalidContentImageException
     */
    public function upload(?UploadedFileInterface $file): ?string
    {
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new InvalidContentImageException('Не удалось загрузить изображение.');
        }

        $tmpPath = $file->getStream()->getMetadata('uri');
        $imageInfo = is_string($tmpPath) ? @getimagesize($tmpPath) : false;
        $extension = $imageInfo === false ? null : (self::MIME_EXTENSIONS[$imageInfo['mime']] ?? null);

        if ($extension === null) {
            throw new InvalidContentImageException('Допустимы только изображения форматов JPG, PNG, WEBP, GIF.');
        }

        $directory = $this->aliases->get('@public/images');

        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new InvalidContentImageException('Не удалось сохранить изображение.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $file->moveTo($directory . '/' . $filename);

        return '/images/' . $filename;
    }
}

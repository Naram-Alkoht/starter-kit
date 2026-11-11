<?php

declare(strict_types=1);

namespace App\Services\Media;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class MediaUrl
{
    /**
     * The URL of a conversion, or of the original file while the queue has
     * not made the conversion yet. An empty conversion name is the original.
     */
    public static function for(?Media $media, string $conversion = ''): ?string
    {
        return $media?->getAvailableUrl([$conversion]);
    }
}

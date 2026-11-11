<?php

declare(strict_types=1);

namespace App\Services\Media;

use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

final class CustomPathGenerator implements PathGenerator
{
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'conversions/';
    }

    public function getPath(Media $media): string
    {
        return Config::string('media-library.prefix').'/'.
            $media->created_at?->format('Y/m').
            '/'.
            $media->id.
            '/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'responsive-images/';
    }
}

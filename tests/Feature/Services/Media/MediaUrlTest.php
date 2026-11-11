<?php

declare(strict_types=1);

use App\Services\Media\MediaUrl;
use Illuminate\Support\Facades\Date;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

function storedMedia(): Media
{
    $media = new Media;
    $media->id = 7;
    $media->created_at = Date::parse('2026-03-05');
    $media->disk = 'public';
    $media->file_name = 'photo.png';
    $media->generated_conversions = [];

    return $media;
}

it('returns null when there is no media', function (): void {
    expect(MediaUrl::for(null))->toBeNull();
});

it('falls back to the original file URL while the conversion is not generated yet', function (): void {
    config(['media-library.prefix' => 'media', 'filesystems.disks.public.url' => 'https://app.test/storage']);

    expect(MediaUrl::for(storedMedia(), 'thumb'))->toBe('https://app.test/storage/media/2026/03/7/photo.png');
});

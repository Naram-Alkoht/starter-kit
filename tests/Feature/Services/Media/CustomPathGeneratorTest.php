<?php

declare(strict_types=1);

use App\Services\Media\CustomPathGenerator;
use Illuminate\Support\Facades\Date;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

it('stores media under the prefix, the year and month it was created, and its id', function (): void {
    config(['media-library.prefix' => 'media']);
    $media = new Media;
    $media->id = 7;
    $media->created_at = Date::parse('2026-03-05');
    $generator = new CustomPathGenerator;

    expect($generator->getPath($media))->toBe('media/2026/03/7/');
    expect($generator->getPathForConversions($media))->toBe('media/2026/03/7/conversions/');
    expect($generator->getPathForResponsiveImages($media))->toBe('media/2026/03/7/responsive-images/');
});

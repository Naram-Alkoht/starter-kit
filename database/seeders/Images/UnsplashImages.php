<?php

declare(strict_types=1);

namespace Database\Seeders\Images;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

final class UnsplashImages
{
    /**
     * The local file of an Unsplash photo. The first call downloads it into
     * `storage/app/private/seed-images/` (not in git); every later call, and
     * every later seed run, uses that file. Seeders add it to the media
     * library with `preservingOriginal()`, so the cache stays.
     */
    public function path(string $id): string
    {
        $disk = Storage::disk('local');
        $file = "seed-images/{$id}.jpg";

        if (! $disk->exists($file)) {
            $disk->put($file, Http::retry(3, 1000)->get("https://images.unsplash.com/photo-{$id}?w=1200&q=80")->throw()->body());
        }

        return $disk->path($file);
    }
}

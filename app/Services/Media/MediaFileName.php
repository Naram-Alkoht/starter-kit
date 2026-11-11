<?php

declare(strict_types=1);

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

final class MediaFileName
{
    /**
     * The name of an uploaded file on the public disk. The client's name is
     * never used: `x.html` with image content would be served as HTML (XSS).
     * The extension comes from the content, and the random name makes the
     * public URL impossible to guess.
     */
    public static function for(UploadedFile $file): string
    {
        return Str::random(40).'.'.$file->extension();
    }
}

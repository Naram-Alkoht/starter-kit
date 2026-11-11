<?php

declare(strict_types=1);

use App\Services\Media\MediaFileName;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

afterEach(fn () => Str::createRandomStringsNormally());

it('names the file with a random name and the extension of its content, not the client name', function (): void {
    Str::createRandomStringsUsing(fn (int $length): string => str_repeat('a', $length));
    $png = tempnam(sys_get_temp_dir(), 'png');
    file_put_contents($png, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg=='));
    $file = new UploadedFile($png, 'x.html', 'text/html', null, true);

    expect(MediaFileName::for($file))->toBe(str_repeat('a', 40).'.png');
});

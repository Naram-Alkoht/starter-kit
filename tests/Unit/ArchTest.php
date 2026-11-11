<?php

declare(strict_types=1);

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

arch()->preset()->php();
arch()->preset()->laravel()->ignoring('App\Providers\Filament');
arch()->preset()->security();

arch('strict rules')
    ->expect('App')
    ->toUseStrictTypes()
    ->toUseStrictEquality();

arch('final classes')
    ->expect('App')
    ->classes()
    ->toBeFinal()
    ->ignoring('App\Filament');

arch('no abstract classes')
    ->expect('App')
    ->classes()
    ->not->toBeAbstract()
    ->ignoring('App\Filament');

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

test('request data reaches models only through validated()', function (): void {
    $offenders = collect(Finder::create()->files()->name('*.php')->in(dirname(__DIR__, 2).'/app'))
        ->filter(fn (SplFileInfo $file): bool => preg_match('/(\$request|request\(\))->(all|input)\(\s*\)/', $file->getContents()) === 1)
        ->map(fn (SplFileInfo $file): string => $file->getRelativePathname())
        ->values()
        ->all();

    expect($offenders)->toBeEmpty();
});

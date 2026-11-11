<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;

function bootAppServiceProviderIn(string $environment): void
{
    app()->instance('env', $environment);
    (new AppServiceProvider(app()))->boot();
}

// The defaults are static, so a production boot must not leak into later tests.
afterEach(fn () => bootAppServiceProviderIn('testing'));

it('uses strict models, immutable dates and the framework password minimum outside production', function (): void {
    expect(Model::preventsLazyLoading())->toBeTrue();
    expect(now())->toBeInstanceOf(CarbonImmutable::class);
    expect(Password::default()->appliedRules())->toMatchArray(['min' => 8, 'mixedCase' => false]);
});

it('requires strong passwords, eager loads and refuses destructive commands in production', function (): void {
    bootAppServiceProviderIn('production');

    expect(Password::default()->appliedRules())->toMatchArray([
        'min' => 12,
        'mixedCase' => true,
        'letters' => true,
        'numbers' => true,
        'symbols' => true,
        'uncompromised' => true,
    ]);
    expect(Model::isAutomaticallyEagerLoadingRelationships())->toBeTrue();
    $this->artisan('db:wipe')->expectsOutputToContain('prohibited')->assertFailed();
});

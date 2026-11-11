<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('makes initials from the first and last word of the name', function (string $name, string $initials): void {
    expect(User::factory()->make(['name' => $name])->initials())->toBe($initials);
})->with([
    'one word' => ['Naram', 'N'],
    'three words' => ['Naram Bassam Alkoht', 'NA'],
]);

it('stores the password as a hash', function (): void {
    $user = User::factory()->create(['password' => 'secret-password']);

    expect(Hash::check('secret-password', $user->password))->toBeTrue();
});

it('does not expose the password or remember token when serialized', function (): void {
    $user = User::factory()->create();

    expect($user->toArray())->not->toHaveKeys(['password', 'remember_token']);
});

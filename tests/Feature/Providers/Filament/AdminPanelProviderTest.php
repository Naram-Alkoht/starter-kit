<?php

declare(strict_types=1);

it('redirects a guest from the admin panel to its login page', function (): void {
    $this->get('/admin')->assertRedirect('/admin/login');
});

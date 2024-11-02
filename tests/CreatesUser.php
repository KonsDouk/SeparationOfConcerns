<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;

trait CreatesUser
{
    public function createUserOfType(string $userType): User
    {
        if ($userType === User::USER_PREMIUM) {
            return User::factory()->premium()->create();
        }

        return User::factory()->create();
    }
}

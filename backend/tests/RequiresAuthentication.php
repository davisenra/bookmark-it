<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait RequiresAuthentication
{
    public function login(): User
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        return $user;
    }
}

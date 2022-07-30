<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker;

    protected $admin = null;

    protected function setUp(): void {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    protected function signIn($user = null) {
        $user = $user ?: User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}

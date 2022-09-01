<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UsersTest extends TestCase
{

    /** @test **/
    public function first_user_is_an_admin() {
        // first user is created in TestCase SetUp()
        $user = User::find(1);
        $this->assertTrue((boolean)$user->admin);
    }

    /** @test **/
    public function users_added_after_the_first_are_not_admins() {
        $this->assertTrue((boolean)$this->admin->admin);
        $this->assertNull(User::factory()->create()->admin);
        $this->assertNull(User::factory()->create()->admin);
    }

    /** @test **/
    public function guests_cannot_manage_users() {
        $this->get('/users')->assertRedirect('login');
        $this->get('/users/create')->assertRedirect('login');
        $this->post('users', $attributes = [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'admin' => false,
            ])
            ->assertRedirect('login');
        $this->assertCount(1, User::all());

        $other_user = User::factory()->create();
        $this->patch('users/' . $other_user->id, $attributes)->assertRedirect('login');
        $this->delete('users/' . $other_user->id)->assertRedirect('login');
        $this->assertCount(2, User::all());
    }

    /** @test **/
    public function non_admins_cannot_manage_users() {
        $this->signIn();

        $this->get('/users')->assertStatus(403);
        $this->get('/users/create')->assertStatus(403);
        $this->post('users', $attributes = [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'admin' => false,
            ])
            ->assertStatus(403);
        $this->assertCount(2, User::all());

        $other_user = User::factory()->create();
        $this->patch('users/' . $other_user->id, $attributes)->assertStatus(403);
        $this->delete('users/' . $other_user->id)->assertStatus(403);
        $this->assertCount(3, User::all());
    }

    /** @test **/
    public function an_admin_can_create_users() {
        $admin_user = $this->admin;

        $this->actingAs($admin_user)
            ->post('users', [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'admin' => false,
            ])
            ->assertRedirect('users');

        $this->assertCount(2, User::all());
    }

    /** @test **/
    public function an_admin_can_update_users() {
        $admin_user = $this->admin;

        $user_to_update = User::factory()->create();

        $this->actingAs($admin_user)
            ->patch('users/' . $user_to_update->id, [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'admin' => false,
            ])
            ->assertRedirect('users');

        $this->assertCount(2, User::all());
    }

    /** @test **/
    public function an_admin_can_delete_users() {
        $admin_user = $this->admin;
        $delete_user = User::factory()->create();
        $this->assertCount(2, User::all());

        $this->actingAs($admin_user)
            ->delete('users/' . $delete_user->id)
            ->assertRedirect('users');

        $this->assertCount(1, User::all());
    }
}

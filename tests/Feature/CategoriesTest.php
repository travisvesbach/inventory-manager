<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test **/
    public function guests_cannot_manage_dice_tables() {
        $category = Category::factory()->create();

        $this->get(route('categories.index'))->assertRedirect('login');
        $this->get(route('categories.create'))->assertRedirect('login');
        $this->get(route('categories.show', $category->id))->assertRedirect('login');
        $this->post(route('categories.store'), $category->toArray())->assertRedirect('login');
    }

    /** @test **/
    public function a_user_can_create_a_category() {
        $this->signIn();

        $this->get(route('categories.create'))->assertStatus(200);

        $attributes = Category::factory()->raw();

        $response = $this->post(route('categories.store'), $attributes);

        $category = Category::where('name', $attributes['name'])->first();

        $response->assertRedirect($category->path());

        $this->assertDatabaseHas('categories', ['name' => $attributes['name']]);

        $this->get($category->path())
            ->assertSee($attributes['name']);
    }

    /** @test **/
    public function an_authenticated_user_can_update_categories() {
        // $this->withoutExceptionHandling();
        $category = Category::factory()->create();

        $attributes = Category::factory()->raw();
        $attributes['name'] = 'changed';

        // var_dump($category->path());

        $this->actingAs($category->user)
            ->patch($category->path(), $attributes)
            ->assertRedirect($category->path());

        $this->assertDatabaseHas('categories', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_their_dice_table() {
        $dice_table = DiceTable::factory()->create();

        $this->actingAs($dice_table->user)
            ->get($dice_table->path())
            ->assertSee($dice_table->name);
    }

    /** @test **/
    public function unathorized_users_cannot_delete_dice_tables() {
        $dice_table = DiceTable::factory()->create();

        $this->delete($dice_table->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($dice_table->path())->assertStatus(403);
    }

    /** @test **/
    public function a_dice_table_requires_a_name() {
        $this->signIn();

        $attributes = DiceTable::factory()->raw(['name' => '']);

        $this->post(route('dice_tables.store'), $attributes)->assertSessionHasErrors('name');
    }
}

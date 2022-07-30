<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;

class CategoriesTest extends TestCase
{
    /** @test **/
    public function guests_cannot_manage_categories() {
        $category = Category::factory()->create();

        $this->get(route('categories.index'))->assertRedirect('login');
        $this->get(route('categories.create'))->assertRedirect('login');
        $this->get(route('categories.show', $category->id))->assertRedirect('login');
        $this->post(route('categories.store'), $category->toArray())->assertRedirect('login');

        $category = Category::factory()->create();

        $this->delete($category->path())
            ->assertRedirect(route('login'));
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
    public function a_user_can_update_categories() {
        $this->signIn();

        $category = Category::factory()->create();

        $attributes = Category::factory()->raw();
        $attributes['name'] = 'changed';

        $this->patch($category->path(), $attributes)
            ->assertRedirect($category->path());

        $this->assertDatabaseHas('categories', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_categories() {
        $this->signIn();

        $category = Category::factory()->create();
        $this->get($category->path())
            ->assertSee($category->name);
    }

    /** @test **/
    public function a_user_can_delete_categories() {
        $this->signIn();

        $category = Category::factory()->create();

        $this->delete($category->path())
            ->assertStatus(302)
            ->assertRedirect(route('categories.index'),);

        $this->assertSoftDeleted($category);
    }

    /** @test **/
    public function a_category_requires_a_name() {
        $this->signIn();

        $attributes = Category::factory()->raw(['name' => '']);

        $this->post(route('categories.store'), $attributes)->assertSessionHasErrors('name');
    }
}

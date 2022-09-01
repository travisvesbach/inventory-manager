<?php

namespace Tests\Feature;

use Tests\TestCase as TestCase;
use App\Models\User;

// TestCase that other feature tests can inherit and use for common tests
class FeatureTestCase extends TestCase
{
    protected $route        = null;
    protected $model        = null;
    protected $exists_fields = null;

    protected function guestsCannotManage($assert_count_one = 0, $assert_count_two = 1) {
        $this->get(route($this->route . '.index'))->assertRedirect('login');
        $this->get(route($this->route . '.create'))->assertRedirect('login');
        $attributes = $this->createAttributes();
        $this->post(route($this->route . '.store'), $attributes)->assertRedirect('login');
        $this->assertCount($assert_count_one, $this->model::all());

        $item = $this->model::factory()->create();
        $this->patch(route($this->route . '.update', $item->id), $attributes)->assertRedirect('login');
        $this->delete(route($this->route . '.destroy', $item->id))->assertRedirect('login');
        $this->assertCount($assert_count_two, $this->model::all());
    }

    // copy and overwrite in child test if redirects, etc. are different
    protected function userCanCreate($assert_count = 1) {
        $user = User::factory()->create();
        $attributes = $this->createAttributes();
        $this->actingAs($user)
            ->post(route($this->route . '.store', $attributes))
            ->assertRedirect(route($this->route . '.show', 1));

        $this->assertCount($assert_count, $this->model::all());
        $this->itemExistsWithAttributes($attributes);
    }

    // copy and overwrite in child test if redirects, etc. are different
    protected function userCanView($assert_count = 1) {
        $this->signIn();
        $item = $this->model::factory()->create();
        $this->get($item->path())
            ->assertSee($item->name);
    }

    // copy and overwrite in child test if redirects, etc. are different
    protected function userCanUpdate() {
        $user = User::factory()->create();
        $toUpdate = $this->model::factory()->create();
        $attributes = $this->createAttributes();
        $this->actingAs($user)
            ->patch(route($this->route . '.update', $toUpdate->id), $attributes)
            ->assertRedirect(route($this->route . '.show', 1));

        $this->itemExistsWithAttributes($attributes);
    }

    // copy and overwrite in child test if redirects, etc. are different
    protected function userCanDelete($assert_count_one = 1, $assert_count_two = 0) {
        $user = User::factory()->create();
        $to_delete = $this->model::factory()->create();
        $this->assertCount($assert_count_one, $this->model::all());

        $this->actingAs($user)
            ->delete(route($this->route . '.destroy', $to_delete->id))
            ->assertRedirect(route($this->route . '.index'));

        $this->assertCount($assert_count_two, $this->model::all());
    }


    protected function userCanBulkDelete() {
        $this->signIn();

        $items[] = $this->model::factory()->create()->id;
        $items[] = $this->model::factory()->create()->id;
        $items[] = $this->model::factory()->create()->id;

        $this->post(route($this->route . '.bulk_destroy', ['ids' => $items]))
            ->assertRedirect(route($this->route . '.index'),);

        foreach($items as $id) {
            $this->assertSoftDeleted($this->model, ['id' => $id]);
        }
    }

    // assert that item with passed attributes exists in database
    protected function itemExistsWithAttributes($attributes) {
        $array = null;
        if(is_array($this->exists_fields) && count($this->exists_fields) > 0) {
            $array = [];
            foreach($this->exists_fields as $field) {
                $array[$field] = $attributes[$field];
            }
        }
        $this->assertDatabaseHas($this->model, $array);
    }

    protected function createAttributes() {
        return $this->model::factory()->raw();
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Asset;

class AssetsTest extends TestCase
{
    /** @test **/
    public function guests_cannot_manage_assets() {
        $asset = Asset::factory()->create();

        $this->get(route('assets.index'))->assertRedirect('login');
        $this->get(route('assets.create'))->assertRedirect('login');
        $this->get(route('assets.show', $asset->id))->assertRedirect('login');
        $this->post(route('assets.store'), $asset->toArray())->assertRedirect('login');

        $asset = Asset::factory()->create();

        $this->delete($asset->path())
            ->assertRedirect(route('login'));
    }

    /** @test **/
    public function a_user_can_create_an_asset() {
        $this->signIn();

        $this->withoutExceptionHandling();

        $this->get(route('assets.create'))->assertStatus(200);
        $attributes = Asset::factory()->raw();
        $response = $this->post(route('assets.store'), $attributes);
        $asset = Asset::where('name', $attributes['name'])->first();

        $response->assertRedirect($asset->path());

        $this->assertDatabaseHas('assets', ['name' => $attributes['name']]);
        $this->get($asset->path())
            ->assertSee($attributes['name']);
    }

    /** @test **/
    public function a_user_can_update_assets() {
        $this->signIn();

        $asset = Asset::factory()->create();

        $attributes = Asset::factory()->raw();
        $attributes['name'] = 'changed';

        $this->patch($asset->path(), $attributes)
            ->assertRedirect($asset->path());

        $this->assertDatabaseHas('assets', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_assets() {
        $this->signIn();

        $asset = Asset::factory()->create();
        $this->get($asset->path())
            ->assertSee($asset->name);
    }

    /** @test **/
    public function a_user_can_delete_assets() {
        $this->signIn();

        $asset = Asset::factory()->create();

        $this->delete($asset->path())
            ->assertStatus(302)
            ->assertRedirect(route('assets.index'),);

        $this->assertSoftDeleted($asset);
    }

    /** @test **/
    public function an_asset_requires_a_name() {
        $this->signIn();

        $attributes = Asset::factory()->raw(['name' => '']);

        $this->post(route('assets.store'), $attributes)->assertSessionHasErrors('name');
    }

    /** @test **/
    public function an_asset_requires_a_category() {
        $this->signIn();

        $attributes = Asset::factory()->raw(['category_id' => null]);

        $this->post(route('assets.store'), $attributes)->assertSessionHasErrors('category_id');
    }

    /** @test **/
    public function a_user_can_bulk_delete_assets() {
        $this->signIn();

        $assets[] = Asset::factory()->create()->id;
        $assets[] = Asset::factory()->create()->id;
        $assets[] = Asset::factory()->create()->id;

        $this->post(route('assets.bulk_destroy', ['ids' => $assets]))
            ->assertRedirect(route('assets.index'),);

        foreach($assets as $id) {
            $this->assertSoftDeleted('assets', ['id' => $id]);
        }
    }
}

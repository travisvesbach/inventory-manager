<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Location;

class LocationsTest extends TestCase
{
    /** @test **/
    public function guests_cannot_manage_locations() {
        $location = Location::factory()->create();

        $this->get(route('locations.index'))->assertRedirect('login');
        $this->get(route('locations.create'))->assertRedirect('login');
        $this->get(route('locations.show', $location->id))->assertRedirect('login');
        $this->post(route('locations.store'), $location->toArray())->assertRedirect('login');

        $location = Location::factory()->create();

        $this->delete($location->path())
            ->assertRedirect(route('login'));
    }

    /** @test **/
    public function a_user_can_create_a_location() {
        $this->signIn();

        $this->get(route('locations.create'))->assertStatus(200);
        $attributes = Location::factory()->raw();
        $response = $this->post(route('locations.store'), $attributes);
        $location = Location::where('name', $attributes['name'])->first();

        $response->assertRedirect($location->path());

        $this->assertDatabaseHas('locations', ['name' => $attributes['name']]);
        $this->get($location->path())
            ->assertSee($attributes['name']);
    }

    /** @test **/
    public function a_user_can_update_locations() {
        $this->signIn();

        $location = Location::factory()->create();

        $attributes = Location::factory()->raw();
        $attributes['name'] = 'changed';

        $this->patch($location->path(), $attributes)
            ->assertRedirect($location->path());

        $this->assertDatabaseHas('locations', ['name' => 'changed']);
    }

    /** @test **/
    public function a_user_can_view_locations() {
        $this->signIn();

        $location = Location::factory()->create();
        $this->get($location->path())
            ->assertSee($location->name);
    }

    /** @test **/
    public function a_user_can_delete_locations() {
        $this->signIn();

        $location = Location::factory()->create();

        $this->delete($location->path())
            ->assertStatus(302)
            ->assertRedirect(route('locations.index'),);

        $this->assertSoftDeleted($location);
    }

    /** @test **/
    public function a_location_requires_a_name() {
        $this->signIn();

        $attributes = Location::factory()->raw(['name' => '']);

        $this->post(route('locations.store'), $attributes)->assertSessionHasErrors('name');
    }


    /** @test **/
    public function a_user_can_bulk_delete_locations() {
        $this->signIn();

        $locations[] = Location::factory()->create()->id;
        $locations[] = Location::factory()->create()->id;
        $locations[] = Location::factory()->create()->id;

        $this->post(route('locations.bulk_destroy', ['ids' => $locations]))
            ->assertRedirect(route('locations.index'),);

        foreach($locations as $id) {
            $this->assertSoftDeleted('locations', ['id' => $id]);
        }
    }
}

<?php

namespace Tests\Feature;

use Tests\Feature\FeatureTestCase;
use App\Models\Asset;

class AssetsTest extends FeatureTestCase
{
    protected $route        = 'assets';
    protected $permission   = 'assets';
    protected $model        = '\App\Models\Asset';
    protected $exists_fields = [
        'name',
        'acquisition_date',
        'acquisition_price',
        'info_url',
        'notes',
        'category_id',
    ];

    protected function setUp(): void {
        parent::setUp();
        \App\Models\Category::factory()->create();
    }

    /** @test **/
    public function guests_cannot_manage_assets() {
        $this->guestsCannotManage();
    }

    /** @test **/
    public function a_user_can_create_assets() {
        $this->userCanCreate();
    }

    /** @test **/
    public function a_user_can_view_assets() {
        $this->userCanView();
    }

    /** @test **/
    public function a_user_can_update_assets() {
        $this->userCanUpdate();
    }

    /** @test **/
    public function a_user_can_delete_assets() {
        $this->userCanDelete();
    }

    /** @test **/
    public function a_user_can_bulk_delete_assets() {
        $this->userCanBulkDelete();
    }

    /** @test **/
    public function an_asset_requires_a_name() {
        $this->fieldRequired('name');
    }

    /** @test **/
    public function an_asset_requires_a_category() {
        $this->fieldRequired('category_id');
    }

    /** @test **/
    public function a_user_can_checkout_an_asset() {
        $user = \App\Models\User::factory()->create();
        $asset = $this->model::factory()->create();
        $checkout_to = $this->model::factory()->create();

        $checkout_date = $this->faker->date();
        $this->actingAs($user)
            ->post(route($this->route . '.checkout', $asset), [
                'parent_id'      => $checkout_to->id,
                'checkout_date' => $checkout_date,
            ])
            ->assertRedirect(route($this->route . '.show', $asset->id));

        $this->assertEquals($asset->refresh()->parent_id, $checkout_to->id);
        $this->assertEquals($asset->refresh()->checkout_date, $checkout_date);
    }
}

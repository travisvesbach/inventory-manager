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
}

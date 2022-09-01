<?php

namespace Tests\Feature;

use Tests\Feature\FeatureTestCase;

class LocationsTest extends FeatureTestCase
{
    protected $route        = 'locations';
    protected $permission   = 'locations';
    protected $model        = '\App\Models\Location';
    protected $exists_fields = [
        'name',
        'address',
        'address_secondary',
        'city',
        'state',
        'country',
        'zipcode',
        'latitude',
        'longitude',
    ];

    /** @test **/
    public function guests_cannot_manage_locations() {
        $this->guestsCannotManage();
    }

    /** @test **/
    public function a_user_can_create_locations() {
        $this->userCanCreate();
    }

    /** @test **/
    public function a_user_can_view_locations() {
        $this->userCanView();
    }

    /** @test **/
    public function a_user_can_update_locations() {
        $this->userCanUpdate();
    }

    /** @test **/
    public function a_user_can_delete_locations() {
        $this->userCanDelete();
    }

    /** @test **/
    public function a_user_can_bulk_delete_locations() {
        $this->userCanBulkDelete();
    }
}

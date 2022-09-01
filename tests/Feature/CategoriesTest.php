<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;

use Tests\Feature\FeatureTestCase;

class CategoriesTest extends FeatureTestCase
{
    protected $route        = 'categories';
    protected $permission   = 'categories';
    protected $model        = '\App\Models\Category';
    protected $exists_fields = [
        'name',
    ];

    /** @test **/
    public function guests_cannot_manage_categories() {
        $this->guestsCannotManage();
    }

    /** @test **/
    public function a_user_can_create_categories() {
        $this->userCanCreate();
    }

    /** @test **/
    public function a_user_can_view_categories() {
        $this->userCanView();
    }

    /** @test **/
    public function a_user_can_update_categories() {
        $this->userCanUpdate();
    }

    /** @test **/
    public function a_user_can_delete_categories() {
        $this->userCanDelete();
    }

    /** @test **/
    public function a_user_can_bulk_delete_categories() {
        $this->userCanBulkDelete();
    }

    /** @test **/
    public function a_category_requires_a_name() {
        $this->fieldRequired('name');
    }

}

<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('users', UsersController::class);
    Route::resource('categories', CategoriesController::class);
    Route::post('categories/bulk_destroy', [CategoriesController::class, 'bulkDestroy'])->name('categories.bulk_destroy');

    Route::resource('locations', LocationsController::class);
    Route::post('locations/bulk_destroy', [LocationsController::class, 'bulkDestroy'])->name('locations.bulk_destroy');

    Route::resource('assets', AssetsController::class);
    Route::post('assets/bulk_destroy', [AssetsController::class, 'bulkDestroy'])->name('assets.bulk_destroy');
    Route::post('assets/{asset}/checkout', [AssetsController::class, 'checkout'])->name('assets.checkout');
});

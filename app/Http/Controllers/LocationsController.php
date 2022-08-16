<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\LocationRequest;

class LocationsController extends Controller
{
    public function index() {
        $locations = Location::orderBy('name')->with('parent')->get();
        return Inertia::render('Locations/Index', compact(['locations']));
    }

    public function create() {
        $locations = Location::select(['id', 'name', 'parent_id'])->orderBy('name')->get();
        return Inertia::render('Locations/Edit', compact(['locations']));
    }

    public function store(LocationRequest $request) {
        $location = new Location;
        $location->fill($request->validated());
        $location->save();

        return redirect($location->path())->with(['flash_message' => $location->name . ' created', 'flash_status' => 'success']);
    }

    public function show(Location $location) {
        $location->load(['parent', 'children', 'assets']);
        $all_assets = $location->allAssets()->toArray();
        return Inertia::render('Locations/Show', compact(['location', 'all_assets']));
    }

    public function edit(Location $location) {
        $locations = Location::select(['id', 'name', 'parent_id'])->orderBy('name')->get();
        return Inertia::render('Locations/Edit', ['editing' => $location, 'locations' => $locations]);
    }

    public function update(LocationRequest $request, Location $location) {
        $location->update($request->validated());
        $location->save();

        return redirect($location->path())->with(['flash_message' => $location->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Location $location) {
        $location->delete();

        return redirect(route('locations.index'))->with(['flash_message' => $location->name . ' deleted', 'flash_status' => 'danger']);
    }

    public function bulkDestroy(Request $request) {
        if($request->filled('ids')) {
            Location::whereIn('id', $request->input('ids'))->delete();
        }
        return redirect(route('locations.index'))->with(['flash_message' => count($request->input('ids')) . ' locations deleted', 'flash_status' => 'danger']);;
    }
}

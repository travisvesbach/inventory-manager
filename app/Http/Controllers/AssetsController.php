<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\AssetRequest;
use App\Models\User;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Carbon\Carbon;

class AssetsController extends Controller
{
    public function index() {
        $assets = Asset::orderBy('name')->with('category', 'location', 'parent')->get();
        return Inertia::render('Assets/Index', compact(['assets']));
    }

    public function create() {
        $categories = Category::select(['id', 'name'])->orderBy('name')->get();
        $locations = Location::select(['id', 'name'])->orderBy('name')->get();
        $assets = Asset::select(['id', 'name'])->orderBy('name')->get();
        return Inertia::render('Assets/Edit', compact(['categories', 'locations', 'assets']));
    }

    public function store(AssetRequest $request) {
        $asset = new Asset;
        $asset->fill($request->validated());
        if($asset->parent) {
            $asset->location_id = $asset->parent->location_id;
        }
        $asset->save();

        return redirect($asset->path())->with(['flash_message' => $asset->name . ' created', 'flash_status' => 'success']);
    }

    public function show(Asset $asset) {
        $asset->load(['category', 'location', 'parent', 'children']);
        $all_assets = $asset->allChildren()->toArray();
        return Inertia::render('Assets/Show', compact(['asset', 'all_assets']));
    }

    public function edit(Asset $asset) {
        $categories = Category::select(['id', 'name', 'parent_id'])->orderBy('name')->get();
        $locations = Location::select(['id', 'name'])->orderBy('name')->get();
        $assets = Asset::whereNot('id', $asset->id)->select(['id', 'name'])->orderBy('name')->get();
        return Inertia::render('Assets/Edit', ['editing' => $asset, 'categories' => $categories, 'locations' => $locations, 'assets' => $assets]);
    }

    public function update(AssetRequest $request, Asset $asset) {
        $asset->update($request->validated());
        if($asset->parent) {
            $asset->location_id = $asset->parent->location_id;
        }
        $asset->save();
        if($asset->children) {
            foreach($asset->allChildren() as $child) {
                $child->location_id = $asset->location_id;
                $child->save();
            }
        }

        return redirect($asset->path())->with(['flash_message' => $asset->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Asset $asset) {
        $asset->delete();

        return redirect(route('assets.index'))->with(['flash_message' => $asset->name . ' deleted', 'flash_status' => 'danger']);
    }

    public function bulkDestroy(Request $request) {
        if($request->filled('ids')) {
            Asset::whereIn('id', $request->input('ids'))->delete();
        }
        return redirect(route('assets.index'))->with(['flash_message' => count($request->input('ids')) . ' assets deleted', 'flash_status' => 'danger']);
    }

    public function checkout(Asset $asset, Request $request) {
        if($request->filled('parent_id')) {
            $checkout_to = Asset::find($request->input('parent_id'));
            $asset->parent_id = $checkout_to->id;
            $asset->checkout_date = $request->input('checkout_date') ?? null;
            $asset->save();
            return redirect(route('assets.show', $asset))->with(['flash_message' => $asset->name . ' checked out to ' . $checkout_to->name, 'flash_status' => 'success']);
        }
    }
}

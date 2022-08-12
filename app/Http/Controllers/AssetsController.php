<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\AssetRequest;
use App\Models\User;
use App\Models\Asset;
use App\Models\Category;

class AssetsController extends Controller
{
    public function index() {
        $assets = Asset::orderBy('name')->get();
        return Inertia::render('Assets/Index', compact(['categories']));
    }

    public function create() {
        $categories = Category::select(['id', 'name', 'category_id'])->orderBy('name')->get();
        return Inertia::render('Assets/Edit', compact(['categories']));
    }

    public function store(AssetRequest $request) {
        $asset = new Asset;
        $asset->fill($request->validated());
        $asset->save();

        return redirect($asset->path())->with(['flash_message' => $asset->name . ' created', 'flash_status' => 'success']);
    }

    public function show(Asset $asset) {
        return Inertia::render('Assets/Show', compact(['asset']));
    }

    public function edit(Asset $asset) {
        $categories = Category::select(['id', 'name', 'category_id'])->orderBy('name')->get();
        return Inertia::render('Assets/Edit', ['editing' => $asset, 'categories' => $categories]);
    }

    public function update(AssetRequest $request, Asset $asset) {
        $asset->update($request->validated());
        $asset->save();

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
}

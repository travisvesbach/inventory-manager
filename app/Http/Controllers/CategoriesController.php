<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    public function index() {
        $categories = Category::orderBy('name')->with('category')->get();
        return Inertia::render('Categories/Index', compact(['categories']));
    }

    public function create() {
        $categories = Category::select(['id', 'name', 'category_id'])->orderBy('name')->get();
        return Inertia::render('Categories/Edit', compact(['categories']));
    }

    public function store(CategoryRequest $request) {
        $category = new Category;
        $category->fill($request->validated());
        $category->save();

        return redirect($category->path())->with(['flash_message' => $category->name . ' created', 'flash_status' => 'success']);
    }

    public function show(Category $category) {
        $category->load(['category', 'subcategories', 'assets']);
        $all_assets = $category->allAssets()->toArray();
        return Inertia::render('Categories/Show', compact(['category', 'all_assets']));
    }

    public function edit(Category $category) {
        $categories = Category::select(['id', 'name', 'category_id'])->orderBy('name')->get();
        return Inertia::render('Categories/Edit', ['editing' => $category, 'categories' => $categories]);
    }

    public function update(CategoryRequest $request, Category $category) {
        $category->update($request->validated());
        $category->save();

        return redirect($category->path())->with(['flash_message' => $category->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Category $category) {
        $category->delete();

        return redirect(route('categories.index'))->with(['flash_message' => $category->name . ' deleted', 'flash_status' => 'danger']);
    }

    public function bulkDestroy(Request $request) {
        if($request->filled('ids')) {
            Category::whereIn('id', $request->input('ids'))->delete();
        }
        return redirect(route('categories.index'))->with(['flash_message' => count($request->input('ids')) . ' categories deleted', 'flash_status' => 'danger']);
    }
}

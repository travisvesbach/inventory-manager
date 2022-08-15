<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Loggable;
use App\Models\Asset;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Loggable;

    protected $fillable = [
        'name',
        'category_id',
        'icon',
    ];

    protected $appends = [
        'path',
        'asset_count',
        'asset_count_all'
    ];

    public function path() {
        return route('categories.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategories() {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function allSubcategories() {
        return $this->subcategories()->with('allSubcategories');
    }

    public function assets() {
        return $this->hasMany(Asset::class, 'category_id', 'id')->withRelationships();
    }

    // includes assets from subcategories
    public function assetsRecursive($query) {
        foreach($this->subcategories as $subcategory) {
            $query->orWhere('category_id', $subcategory->id);
            $query = $subcategory->assetsRecursive($query);
        }
        return $query;
    }

    public function allAssets() {
        $query = Asset::where('category_id', $this->id);
        return $this->assetsRecursive($query)->orderBy('name')->withRelationships()->get();
    }

    public function getAssetCountAttribute() {
        return $this->assets()->count();
    }

    public function getAssetCountAllAttribute() {
        return $this->allAssets()->count();
    }
}

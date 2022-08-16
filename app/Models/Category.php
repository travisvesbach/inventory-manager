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
        'parent_id',
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

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function allChildren() {
        return $this->children()->with('allChildren');
    }

    public function assets() {
        return $this->hasMany(Asset::class, 'category_id', 'id')->withRelationships();
    }

    // includes assets from children
    public function assetsRecursive($query) {
        foreach($this->children as $child) {
            $query->orWhere('category_id', $child->id);
            $query = $child->assetsRecursive($query);
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

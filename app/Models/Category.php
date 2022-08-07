<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Loggable;

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
}

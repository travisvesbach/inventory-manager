<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Loggable;

class Asset extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Loggable;

    protected $fillable = [
        'name',
        'category_id',
        'location_id',
        'acquisition_date',
        'acquisition_price',
        'disposition_date',
        'disposition_price',
        'info_url',
        'notes',
        'parent_id',
        'checkout_date',
    ];

    protected $appends = [
        'path',
    ];

    protected $casts = [
        'acquisition_date'  => 'date:Y-m-d',
        'disposition_date'  => 'date:Y-m-d'
    ];

    public function path() {
        return route('assets.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function parent() {
        return $this->belongsTo(Asset::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Asset::class, 'parent_id', 'id');
    }

    public function childrenRecursive($query) {
        foreach($this->children as $child) {
            $query->orWhere('parent_id', $child->id);
            $query = $child->childrenRecursive($query);
        }
        return $query;
    }

    public function allChildren() {
        $query = Asset::where('parent_id', $this->id);
        return $this->childrenRecursive($query)->orderBy('name')->withRelationships()->get();
    }

    public function scopeWithRelationships($query)
    {
        $relationships = [
            'category',
            'location',
            'parent'
        ];
        foreach($relationships as $relationship) {
            $query->with([$relationship => function($query) {
                $query->select('id', 'name');
            }]);
        }
        return $query;
    }
}

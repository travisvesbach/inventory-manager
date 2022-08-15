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

    public function scopeWithRelationships($query)
    {
        $relationships = [
            'category',
            'location'
        ];
        foreach($relationships as $relationship) {
            $query->with([$relationship => function($query) {
                $query->select('id', 'name');
            }]);
        }
        return $query;
    }
}

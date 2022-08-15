<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Loggable;
use App\Models\Asset;

class Location extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Loggable;

    protected $fillable = [
        'name',
        'location_id',
        'address',
        'address_secondary',
        'city',
        'state',
        'country',
        'zipcode',
        'latitude',
        'longitude',
    ];

    protected $appends = [
        'path',
        'asset_count',
        'asset_count_all'
    ];

    public function path() {
        return route('locations.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function location() {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function locations() {
        return $this->hasMany(Location::class, 'location_id', 'id');
    }

    public function allLocations() {
        return $this->locations()->with('allLocations');
    }

    public function assets() {
        return $this->hasMany(Asset::class, 'location_id', 'id')->withRelationships();
    }

    // includes assets from locations
    public function assetsRecursive($query) {
        foreach($this->locations as $location) {
            $query->orWhere('location_id', $location->id);
            $query = $location->assetsRecursive($query);
        }
        return $query;
    }

    public function allAssets() {
        $query = Asset::where('location_id', $this->id);
        return $this->assetsRecursive($query)->orderBy('name')->withRelationships()->get();
    }

    public function getAssetCountAttribute() {
        return $this->assets()->count();
    }

    public function getAssetCountAllAttribute() {
        return $this->allAssets()->count();
    }
}

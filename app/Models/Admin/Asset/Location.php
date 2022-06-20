<?php

namespace App\Models\Admin\Asset;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_id',
        'location',
        'is_crud'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('lat_lng', function (Builder $builder) {
            $builder->selectRaw(!app()->environment('testing') ? 'ST_X(location) as latitude' : 'location as latitude')
            ->selectRaw(!app()->environment('testing') ? 'ST_Y(location) as longitude' : 'location as longitude');
        });
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return mixed
     */
    protected static function newFactory()
    {
        return LocationFactory::new();
    }
}

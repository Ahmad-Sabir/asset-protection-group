<?php

namespace App\Models\Admin\Asset;

use App\Models\Media;
use App\Models\Company;
use App\Traits\HasModel;
use App\Traits\HasAttribute;
use Database\Factories\AssetFactory;
use App\Models\Admin\Asset\AssetType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read Location $location
 */
class Asset extends Model
{
    use HasFactory;
    use HasAttribute;
    use SoftDeletes;
    use HasModel;

    protected const DATE_FORMAT = 'date:Y-m-d';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'model',
        'status',
        'company_id',
        'location_id',
        'asset_type_id',
        'number',
        'description',
        'manufacturer',
        'custom_values',
        'purchase_date',
        'purchase_price',
        'replacement_cost',
        'total_useful_life',
        'installation_date',
        'warranty_expiry_date',
        'total_useful_life_date',
        'company_number',
    ];

    /**
     * The attributes that are having special casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date'   => self::DATE_FORMAT,
        'installation_date' => self::DATE_FORMAT,
        'warranty_expiry_date' => self::DATE_FORMAT,
        'total_useful_life' => 'array',
        'custom_values' => 'array',
    ];

     /**
     * Interact with the user's address.
     *
     */
    /** @phpstan-ignore-next-line */
    public function statusName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['status'] ? 'Active' : 'Inactive',
        );
    }

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function medias()
    {
        return $this->belongsToMany(Media::class, 'asset_medias', 'asset_id', 'media_id');
    }

    /**
     * Get location.
     *
     * @return mixed
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get
     *
     * @return mixed
     */
    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return mixed
     */
    protected static function newFactory()
    {
        return AssetFactory::new();
    }

     /**
     * Get company
     *
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get company
     *
     * @return mixed
     */
    public function workOrders()
    {
        return $this->hasMany(workOrder::class);
    }

     /**
     * setup creating boot.
     *
     */
    public static function booted(): void
    {
        static::created(function ($entity) {
            self::updateFormatedId($entity);
        });

        static::softDeleted(function ($entity) {
            self::createDeleteLogs($entity);
        });
    }
}

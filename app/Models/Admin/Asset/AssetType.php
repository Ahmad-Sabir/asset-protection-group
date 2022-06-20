<?php

namespace App\Models\Admin\Asset;

use App\Models\Company;
use App\Traits\HasModel;
use App\Models\Admin\Asset\Asset;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\AssetTypeFactory;
use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company_id',
        'type',
    ];

    /**
     * Get
     *
     * @return mixed
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * Get work orders.
     *
     * @return mixed
     */
    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'asset_type_work_orders', 'asset_type_id', 'work_order_id');
    }

    /**
     * Get work order titles.
     *
     * @return mixed
     */
    public function workOrderTitles()
    {
        return $this->hasMany(AssetTypeTitle::class, 'asset_type_id');
    }


    /**
     * Create a new factory instance for the model.
     *
     * @return mixed
     */
    protected static function newFactory()
    {
        return AssetTypeFactory::new();
    }

    /**
     * App\Models\User::company
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * setup creating boot.
     *
     */
    public static function booted(): void
    {
        static::softDeleted(function ($entity) {
            self::createDeleteLogs($entity);
        });
    }
}

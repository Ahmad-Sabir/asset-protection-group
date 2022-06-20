<?php

namespace App\Models\Admin\WorkOrder;

use App\Models\User;
use App\Models\Media;
use App\Models\Company;
use App\Traits\HasModel;
use App\Traits\HasAttribute;
use App\Models\Admin\Asset\Asset;
use App\Models\Admin\Asset\Location;
use App\Models\Admin\Asset\AssetType;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\WorkOrderFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Admin\WorkOrder\WorkOrderLogs;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\WorkOrder\AdditionalTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrder extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAttribute;
    use HasModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'company_id',
        'assignee_user_id',
        'location_id',
        'asset_id',
        'asset_type_id',
        'work_order_profile_id',
        'number',
        'description',
        'additional_info',
        'flag',
        'priority',
        'type',
        'qualification',
        'on_hold_reason',
        'work_order_type',
        'work_order_frequency',
        'work_order_status',
        'work_order_log_timer',
        'is_pause',
        'timer_status',
        'due_date',
    ];

    /**
     * The attributes that are having special casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date'   => 'date:Y-m-d',
    ];

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function medias()
    {
        return $this->belongsToMany(Media::class, 'work_order_medias', 'work_order_id', 'media_id');
    }

    /**
     * Get
     *
     * @return mixed
     */
    public function additionaltasks()
    {
        return $this->hasMany(AdditionalTask::class, 'work_order_id');
    }

    /**
     * Get
     *
     * @return mixed
     */
    public function timerlogs()
    {
        return $this->hasMany(WorkOrderLogs::class, 'work_order_id');
    }

    /**
     * Get subscription users.
     *
     * @return mixed
     */

    public function assets()
    {
        return $this->asset();
    }

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function media()
    {
        return $this->belongsTo(media::class, 'work_order_profile_id');
    }

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function assetTypes()
    {
        return $this->belongsToMany(AssetType::class, 'asset_type_work_orders', 'work_order_id', 'asset_type_id');
    }

    /**
     * Get subscription users.
     *
     * App\Models\WorkOrder::users
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'assignee_user_id');
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
     * Get company
     *
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return mixed
     */
    protected static function newFactory()
    {
        return WorkOrderFactory::new();
    }

     /**
     * custom filter
     *
     * @return mixed
     */
    /** @phpstan-ignore-next-line */
    public function scopeFilter(Builder $query, array $filter)
    {
        return $query->where(function ($query) use ($filter) {
            foreach ($filter as $field => $value) {
                $value = trim($value);
                $query->when($field == 'global_search', function ($query) use ($value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('number', 'like', "%$value%")
                        ->orWhere('title', 'like', "%$value%")
                        ->orWhereHas('assetType', fn ($query) => $query->where('name', 'like', "%$value%"));
                    });
                })->when($field == 'location' && $value != '', function ($query) use ($value) {
                    $query->WhereHas('asset', function ($query) use ($value) {
                        $query->whereHas('location', fn ($query) => $query->where('name', 'like', "%$value%"));
                    });
                })->when($field == 'current_month', function ($query) {
                    $query->whereMonth('due_date', now()->month);
                })->when($field == 'flag' && !empty($value), function ($query) use ($value) {
                    $query->where('flag', $value);
                })->when($field == 'flag' && empty($value), function ($query) {
                    $query->where('flag', '!=', null);
                })->when($field == 'current_year', function ($query) {
                    $query->whereYear('due_date', now()->year);
                })->when($field == 'asset_type' && !empty($value), function ($query) use ($value) {
                    $query->where(function ($query) use ($value) {
                        $query->WhereHas('assetType', fn ($query) => $query->where('name', 'like', "%$value%"));
                    });
                })->when($field == 'work_order_status', function ($query) use ($value) {
                    $query->where('work_order_status', $value);
                })->when($field == 'range_due_date', function ($query) use ($value) {
                    $range = parseRangeDate($value);
                    $query->whereBetween('due_date', [$range['start_date'], $range['end_date']]);
                })->when($field == 'range_created_at', function ($query) use ($value) {
                    $range = parseRangeDate($value);
                    $query->whereBetween('created_at', [$range['start_date'], $range['end_date']]);
                });
            }
        });
    }

     /**
     * Create a new factory instance for the model.
     *
     * @return mixed
     */
    protected static function frequency()
    {
        return WorkOrderFactory::new();
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

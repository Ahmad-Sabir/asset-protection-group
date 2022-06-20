<?php

namespace App\Models\Admin\WorkOrder;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Media;
use Database\Factories\AdditionalTaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalTask extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'work_order_id',
        'media_id',
        'task_detail',
        'due_date',
        'status',
        'comment'
    ];

    /**
     * The attributes that are having special casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date'   => 'date',
    ];

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function media()
    {
        return $this->belongsTo(media::class, 'media_id');
    }

    /**
     * Get subscription users.
     *
     * @return mixed
     */
    public function workOrder()
    {
        return $this->belongsTo(workOrder::class);
    }

     /**
     * Create a new factory instance for the model.
     *
     * @return mixed
     */
    protected static function newFactory()
    {
        return AdditionalTaskFactory::new();
    }
}

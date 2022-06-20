<?php

namespace App\Models\Admin\WorkOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\WorkOrder\WorkOrder;

class WorkOrderLogs extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'work_order_id',
        'parent_id',
        'time',
        'type',
        'total_log',

    ];

    /**
     * The attributes that are having special casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'time'   => 'datetime',
    ];
}

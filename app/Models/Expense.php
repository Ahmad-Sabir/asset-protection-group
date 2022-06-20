<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\WorkOrder\WorkOrder;
use App\Models\Company;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'type',
        'amount',
        'work_order_id',
        'company_id',
        'expense_date'
    ];

       /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expense_date' => 'date',
    ];

       /**
     * Get
     *
     * @return mixed
     */
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
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
}

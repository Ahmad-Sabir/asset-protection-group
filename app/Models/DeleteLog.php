<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DeleteLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'entity_id',
        'company_id',
        'entity_type',
        'description',
    ];

    /**
     * get user.
     *
     */
    public function user(): mixed
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * get company.
     *
     */
    public function company(): mixed
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    /**
     * get entity.
     *
     */
    public function entity(): mixed
    {
        return $this->morphTo('entity');
    }
}

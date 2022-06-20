<?php

namespace App\Models;

use App\Traits\HasModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
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
        'manager_email',
        'manager_phone',
        'manager_last_name',
        'manager_first_name',
        'deactivate_at',
        'profile_media_id',
        'status',
        'name',
        'designation',
    ];

    /**
     * Interact with the user's address.
     *
     */
    /** @phpstan-ignore-next-line */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => "{$attributes['manager_first_name']} {$attributes['manager_last_name']}",
        );
    }

    /** @phpstan-ignore-next-line */
    public function companyId(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => ucfirst(substr($attributes['name'], 0, 1))
            . '-' . formatedId($attributes['id']),
        );
    }

    /**
     * Get profile image.
     *
     * @return mixed
     */
    public function profile()
    {
        return $this->belongsTo(Media::class, 'profile_media_id');
    }

     /**
     * App\Models\Company::users
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany(User::class);
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

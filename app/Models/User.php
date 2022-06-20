<?php

namespace App\Models;

use App\Traits\HasModel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Admin\WorkOrder\WorkOrder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone',
        'password',
        'last_name',
        'first_name',
        'company_id',
        'deactivate_at',
        'profile_media_id',
        'is_update_password',
        'user_status',
        'per_hour_rate',
        'is_admin_employee',
        'email_setting',
        'notification_setting'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_setting' => 'array',
        'notification_setting' => 'array',
    ];

    /**
     * Interact with the user's address.
     *
     */
    /** @phpstan-ignore-next-line */
    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => "{$attributes['first_name']} {$attributes['last_name']}",
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
     * get company
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
        static::creating(function ($entity) {
            $entity->email_setting = config('apg.email_settings');
            $entity->notification_setting = config('apg.notification_settings');
        });
        static::softDeleted(function ($entity) {
            self::createDeleteLogs($entity);
        });
    }
}

<?php

namespace App\Models;

use App\Models\Admin\Asset\AssetMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Media
 * @property int $id
 * @method assetMedias()
 */
class Media extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medias';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ext',
        'url',
        'hash',
        'size',
        'name',
        'width',
        'height',
        'is_internal_file',
    ];

    /**
     * The url attribute modifier.
     *
     * @param string $value
     * @return string
     */
    public function getUrlAttribute($value)
    {
        return Storage::url($value);
    }

    /**
     * Get asset media.
     *
     * @return mixed
     */
    public function assetMedias()
    {
        return $this->hasMany(AssetMedia::class);
    }
}

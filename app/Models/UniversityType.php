<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static active()
 * @method static latest()
 * @method static find(string $id)
 * @method static findOrFail(string $id)
 * @method static isActive()
 * @method static count()
 * @property mixed $name
 * @property mixed|true $is_active
 */
class UniversityType extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];

    public function scopeActive($query,$params)
    {
        return $query->where('is_active', $params);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }
}

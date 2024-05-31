<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array|true[] $createData)
 * @method static latest()
 * @method static findOrFail(string $id)
 * @method static isActive()
 */
class DegreeLevel extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function scopeActive($query,$params)
    {
        return $query->where('is_active',$params);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active',true);
    }
}

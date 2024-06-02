<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static active()
 * @method static find($id)
 * @method static latest()
 * @method static findOrFail(string $id)
 */
class MajorAndSpecializeName extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'major_and_specialize_names';

    protected $guarded = ['id'];


    public function scopeActive($query)
    {
        return $query->where('is_active',true);
    }

    public function scopeIsActive($query,$params)
    {
        return $query->where('is_active',$params);
    }
}

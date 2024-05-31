<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static active()
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
}

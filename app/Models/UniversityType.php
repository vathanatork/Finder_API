<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static active()
 * @property mixed $name
 * @property mixed|true $is_active
 */
class UniversityType extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
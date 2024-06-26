<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(string[] $array)
 * @method static findOrFail(string $id)
 * @method static latest()
 */
class FinancialAid extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function scopeIsActive($query,$param)
    {
        return $query->where('is_active',$param);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static get()
 * @method static findOrFail(string $id)
 * @method static where(string $string, int $int)
 * @method static count()
 */
class Type extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function careers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Career::class,'careers')->wherePivotNull('deleted_at');
    }

}

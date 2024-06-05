<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $createData)
 * @method static where(string $string, string $id)
 */
class MajorDegreeLevel extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function majors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Major::class,'major_id');
    }

    public function degrees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DegreeLevel::class, 'degree_level_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class CareerEducationLevel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function careers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Career::class,'career_id');
    }

    public function degreeLevels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DegreeLevel::class,'degree_level_id');
    }
}

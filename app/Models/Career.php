<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static findOrFail(string $id)
 */
class Career extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function commonDegreeLevel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DegreeLevel::class,'common_degree_level');
    }

    public function types(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'career_types');
    }

    public function degreeLevels(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(DegreeLevel::class,'career_education_levels');
    }

    public function careerEducationLevels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CareerEducationLevel::class);
    }


    public function scopeIsActive($query,$param)
    {
        return $query->where('is_active',$param);
    }

}

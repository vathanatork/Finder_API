<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function commonDegreeLevel(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(DegreeLevel::class,'common_degree_level');
    }

    public function types(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Type::class, 'career_types');
    }

    public function degreeLevels(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(DegreeLevel::class,'career_education_levels');
    }

}

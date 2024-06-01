<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static active()
 */
class University extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function majors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Major::class,'university_id');
    }

    public function degreeLevels(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(DegreeLevel::class, 'university_degree_levels');
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UniversityType::class,'university_type_id');
    }

    public function scopeSearch($query,$params)
    {
        $search = strtolower($params);
        return $query->whereRaw('LOWER(name) COLLATE utf8mb4_general_ci LIKE ?', ['%' . $search . '%']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active',true);
    }

    public function scopeProvince($query,$params)
    {
        return $query->where('adr_province_id',$params);
    }

    public function scopeType($query,$params)
    {
        return $query->where('university_type_id',$params);
    }

    public function scopeWhereDegree($query,$params)
    {
        return $query->whereHas('degreeLevels', function($query) use ($params) {
            $query->where('degree_level_id', $params);
        });
    }

    public function scopeWhereMajorName($query,$params)
    {
        return $query->whereHas('majors',function ($query) use ($params) {
            $query->where('major_name_id',$params);
        });
    }
}

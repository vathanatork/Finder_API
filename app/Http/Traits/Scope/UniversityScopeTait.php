<?php

namespace App\Http\Traits\Scope;

trait UniversityScopeTait
{

    public function scopeSearch($query, $params)
    {
        $search = strtolower($params);
        return $query->whereRaw('LOWER(name) COLLATE utf8mb4_general_ci LIKE ?', ['%' . $search . '%']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeIsActive($query, $param)
    {
        return $query->where('is_active', $param);
    }

    public function scopeType($query, $params)
    {
        return $query->where('university_type_id', $params);
    }

    public function scopeWhereDegree($query, $params)
    {
        return $query->whereHas('degreeLevels', function ($query) use ($params) {
            $query->where('degree_level_id', $params);
        });
    }

    public function scopeWhereMajorName($query, $params)
    {
        return $query->whereHas('majors', function ($query) use ($params) {
            $query->where('major_name_id', $params);
        });
    }


}

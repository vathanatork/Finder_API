<?php

namespace App\Http\Traits\Scope;

trait AdrScopeTrait
{
    public function scopeProvince($query, $params)
    {
        return $query->where('adr_province_id', $params);
    }

    public function scopeDistrict($query, $params)
    {
        return $query->where('adr_district_id',$params);
    }

    public function scopeCommune($query, $params)
    {
        return $query->where('adr_commune_id',$params);
    }

    public function scopeVillage($query, $params)
    {
        return $query->where('adr_village_id',$params);
    }

}

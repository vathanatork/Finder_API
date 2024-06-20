<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerType extends Model
{
    use HasFactory;

    public function careers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Career::class,'career_id');
    }

    public function types(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Type::class,'type_id');
    }
}

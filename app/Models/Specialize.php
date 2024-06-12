<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialize extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    public function major(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Major::class,'major_id');
    }

    public function specializeName(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MajorAndSpecializeName::class,'major_name_id');
    }

    public function degreeLevels(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(DegreeLevel::class, 'specialize_degree_levels');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static active()
 * @method static latest()
 * @method static findOrFail(string $id)
 */
class Major extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function university(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
       return $this->belongsTo(University::class,'university_id');
    }

    public function majorName(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MajorAndSpecializeName::class,'major_name_id');
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

    public function scopeIsActive($query,$params)
    {
        return $query->where('is_active',$params);
    }

}

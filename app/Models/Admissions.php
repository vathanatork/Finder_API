<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static findOrFail(string $id)
 * @method static latest()
 */
class Admissions extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function university(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(University::class,'university_id');
    }

    public function contact(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ContactInformation::class,'contact_info_id');
    }

    public function scopeIsActive($query,$param)
    {
        return $query->where('is_active',$param);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static findOrFail(string $id)
 * @method static create(array $array)
 * @method static latest()
 * @method static where(string $string, string $id)
 * @method static count()
 * @method static isActive(int $int)
 */
class Scholarship extends Model
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

    public function scopeSearch($query, $params)
    {
        // Convert the search term to lowercase
        $search = strtolower($params);
        // Perform the query with case-insensitive search on name_en and name_kh fields
        return $query->whereRaw('LOWER(name_en) COLLATE utf8mb4_general_ci LIKE ?', ['%' . $search . '%'])
            ->orWhereRaw('LOWER(name_kh) COLLATE utf8mb4_general_ci LIKE ?', ['%' . $search . '%']);
    }

}

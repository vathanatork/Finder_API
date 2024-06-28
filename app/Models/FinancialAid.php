<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(string[] $array)
 * @method static findOrFail(string $id)
 * @method static latest()
 * @method static where(string $string, int $int)
 */
class FinancialAid extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];


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

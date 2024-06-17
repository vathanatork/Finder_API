<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, string $id)
 */
class AdrDistrict extends Model
{
    use HasFactory,SoftDeletes;

    protected array $dates = ['deleted_at'];

    protected $table = 'adr_districts';
    protected $guarded = ['id'];
    protected $fillable = [
        'code',
        'name_kh',
        'name_en',
        'type',
        'reference',
        'image_path',
        'adr_province_id',
    ];
    public function province(): BelongsTo
    {
        return $this->belongsTo(AdrProvince::class, 'adr_province_id');
    }

    public function communes(): HasMany
    {
        return $this->HasMany(AdrCommune::class, 'adr_district_id');
    }

    public function scopeNameIn($query, $names)
    {
        return $query->whereIn('name_en', $names)->orWhereIn('name_kh', $names);
    }
}

<?php

namespace App\Models;

use App\Http\Traits\Scope\AdrScopeTrait;
use App\Http\Traits\Scope\UniversityScopeTait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static active()
 * @method static latest()
 * @method static findOrFail(string $id)
 */
class University extends Model
{
    use HasFactory, SoftDeletes, AdrScopeTrait, UniversityScopeTait;

    protected $guarded = ['id'];

    /** MODEL RELATION */

    public function majors(): HasMany
    {
        return $this->hasMany(Major::class, 'university_id');
    }

    public function degreeLevels(): BelongsToMany
    {
        return $this->belongsToMany(DegreeLevel::class, 'university_degree_levels')->wherePivotNull('deleted_at');
    }

    public function scholarShip(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class,'scholarship_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(UniversityType::class, 'university_type_id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(ContactInformation::class, 'contact_info_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(AdrProvince::class, 'adr_province_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(AdrDistrict::class, 'adr_district_id');
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(AdrCommune::class, 'adr_commune_id');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(AdrVillage::class, 'adr_commune_id');
    }

}

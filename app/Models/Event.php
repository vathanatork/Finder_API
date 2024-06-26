<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static findOrFail(string $id)
 * @method static latest()
 * @method static where(string $string, int $int)
 * @method static count()
 */
class Event extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'start_at' => 'datetime: H:i',
        'end_at' => 'datetime: H:i'
    ];


    public function eventCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EventCategory::class,'event_category_id');
    }

    public function university(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(University::class,'university_id');
    }

    public function scopeIsActive($query,$param)
    {
        return $query->where('is_active',$param);
    }

    public function scopeSearch($query, $params)
    {
        $search = strtolower($params);
        return $query->whereRaw('LOWER(name_en) COLLATE utf8mb4_general_ci LIKE ?', ['%' . $search . '%'])
            ->OrWhereRaw('LOWER(name_kh) COLLATE utf8mb4_general_ci LIKE ?', ['%' . $search . '%']);
    }

    public function scopeWhereCategory($query, $params)
    {
        return $query->where('event_category_id',$params);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 */
class QuestionCareerMapping extends Model
{
    use HasFactory;

    protected $table = 'question_career_mapping';

    protected $guarded = ['id'];

    public function career(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id');
    }

    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id',);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInactive($query,$param)
    {
        return $query->where('is_active', $param);
    }

}

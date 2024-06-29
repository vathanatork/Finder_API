<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static findOrFail($id)
 */
class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function questionCareerMapping(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuestionCareerMapping::class,'question_id');
    }

    public function userResponse(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserResponse::class, 'question_id');
    }

    public function scopeIsActive($query,$param)
    {
        return $query->where('is_active',$param);
    }

}

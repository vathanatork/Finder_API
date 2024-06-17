<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static findOrFail(string $id)
 * @method static get()
 */
class EventCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class,'event_category_id');
    }
}

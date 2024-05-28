<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static active()
 * @method static create(array $array)
 */
class ContactInformation extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'contact_informations';

    protected $guarded = ['id'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

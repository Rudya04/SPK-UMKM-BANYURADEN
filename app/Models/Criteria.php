<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'name',
        'value',
        'slug',
    ];

    public function subCriterias() : HasMany
    {
        return $this->hasMany(SubCriteria::class)->orderBy('value', 'ASC');
    }
}

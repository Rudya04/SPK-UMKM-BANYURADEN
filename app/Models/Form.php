<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Form extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'code',
        'title',
        'expired_date',
    ];

    public function user_ranking(): HasOne
    {
        return $this->hasOne(UserRanking::class);
    }

    public function user_rankings(): HasMany
    {
        return $this->hasMany(UserRanking::class);
    }
}

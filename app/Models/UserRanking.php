<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRanking extends Model
{
    protected $guarded = ['id'];
    protected $table = 'users_rankings';

    protected $fillable = [
        'user_id',
        'alternative_id',
        'reference_code',
    ];

    public function rankings(): HasMany
    {
        return $this->hasMany(Ranking::class, 'user_ranking_id');
    }

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class, 'alternative_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurrentUserRanking extends Model
{
    protected $guarded = ['id'];
    protected $table = 'current_users_rankings';

    protected $fillable = [
        'user_id',
        'reference_code',
    ];

    public function current_alternatives(): HasMany
    {
        return $this->hasMany(CurrentAlternative::class, 'current_user_ranking_id', 'id')
            ->orderByDesc('score');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ranking extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'criteria_id',
        'sub_criteria_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ranking_user', 'ranking_id', 'user_id')->withTimestamps();
    }

    public function user_ranking(): BelongsTo
    {
        return $this->belongsTo(UserRanking::class);
    }

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class, 'criteria_id', 'id');
    }

    public function sub_criteria(): BelongsTo
    {
        return $this->belongsTo(SubCriteria::class, 'sub_criteria_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurrentAlternative extends Model
{
    protected $guarded = ['id'];

    public function current_criterias(): HasMany
    {
        return $this->hasMany(CurrentCriteria::class, 'current_alternative_id', 'id')->orderBy('criteria_id');
    }

}

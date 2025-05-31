<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alternative extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'name',
        'pengusaha_id'
    ];

    public function pengusaha(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengusaha_id', 'id');
    }
}

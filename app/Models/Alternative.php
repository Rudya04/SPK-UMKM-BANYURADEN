<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alternative extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'name',
    ];
}

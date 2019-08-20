<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleTwoFa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'secret_key',
        
    ];

    /**
     * Google2Fa relation with User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}

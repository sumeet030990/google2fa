<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecoveryCode extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'recovery_code'
    ];

    /**
     * Recovery Code BelongsTo User
     * 
     * @return BelongsTo
     */
    function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}

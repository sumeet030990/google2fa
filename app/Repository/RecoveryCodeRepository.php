<?php

namespace App\Repository;

use App\Models\User;
use App\Models\RecoveryCode;
use App\Repository\Repository;

class RecoveryCodeRepository extends Repository
{
    /**
     * RecoveryCode model object
     * @var RecoveryCode
     */
    protected $model;

    /**
     * @param $model
     */
    public function __construct(RecoveryCode $model)
    {
        $this->model = $model;
    }

    /**
     * Store Recovery Codes
     * 
     * @param User $user
     * @param Array $recoveryCodes
     */
    function generateRecoveryCode(User $user, Array $recoveryCodes)
    {
        dd($recoveryCodes, $user->recoveryCodes->create($recoveryCodes));
    }
}

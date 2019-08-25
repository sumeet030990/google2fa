<?php 

namespace App\Services;

use App\Models\User;
use App\Repository\RecoveryCodeRepository;

class RecoveryCodeService {
 
    /**
     * RecoveryCodeService service object.
     *
     * @var RecoveryCodeRepository
     */
    protected $recoveryCodeRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RecoveryCodeRepository $recoveryCodeRepository)
    {
        $this->recoveryCodeRepository = $recoveryCodeRepository;
    }

    /**
     * Generate Recovery Code for User
     */
    // public function generateRecoveryCode(User $user): Array
    public function generateRecoveryCode(User $user)
    {
        // $recoveryCodes = new PragmaRX\Recovery();
        // $recoveryCodes->setCount(5)->toArray(); // generate 5 recovery Codes
        // dd($recoveryCodes);
        // return $this->recoveryCodeRepository->generateRecoveryCode($user, $recoveryCodes);
    }
}
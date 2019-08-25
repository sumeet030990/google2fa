<?php

namespace App\Services;

use App\Models\GoogleTwoFa;
use App\Models\User;
use App\Repository\GoogleTwoFaRepository;

class GoogleTwoFaService
{
     /**
     * GoogleTwoFaService service object.
     *
     * @var GoogleTwoFaRepository
     */
    protected $googleTwoFaRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        GoogleTwoFaRepository $googleTwoFaRepository
    ){
        $this->googleTwoFaRepository = $googleTwoFaRepository;
    }

    /**
     * Generate & Store 2fa Secret key 
     * 
     * @param User
     * @return GoogleTwoFa
     */
    public function generate2faSecret(User $user): GoogleTwoFa
    {
        return $this->googleTwoFaRepository->generate2faSecret($user);
    }
     
    /**
     * Generate QR Code 
     * 
     * @return Array
     */
    public function generateQrCode(): Array
    {
        return $this->googleTwoFaRepository->generateQrCode();
    }

    /**
     * Enable Two FA
     * 
     * @param String $secretKey
     * @return bool
     */
    public function enable2fa(String $secretKey): bool
    {
        return $this->googleTwoFaRepository->enable2Fa($secretKey);
    }

    /**
     * Disable Two FA
     * 
     * @param String $password
     * @return bool
     */
    public function disable2fa(String $password): bool
    {
        return $this->googleTwoFaRepository->disable2Fa($password);
    }
}

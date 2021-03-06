<?php

namespace App\Repository;

use App\Models\GoogleTwoFa;
use App\Models\User;
use App\Repository\Repository;
use Auth;
use Hash;

class GoogleTwoFaRepository extends Repository
{
    /**
     * GoogleTwoFa model object
     * @var GoogleTwoFa
     */
    protected $model;
    
    /**
     * Initialise the 2FA class
     * @var GoogleTwoFa
     */
    protected $google2fa;

    /**
     * @param $model
     */
    public function __construct(GoogleTwoFa $model)
    {
        $this->model = $model;
        $this->google2fa = app('pragmarx.google2fa');
    }

    /**
     * Generate & Store 2fa Secret key 
     * 
     * @param User
     * @return GoogleTwoFa
     */
    public function generate2faSecret(User $user): GoogleTwoFa
    {
        // Add the secret key to the registration data
        return $this->model->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'status' => 0,
                'secret_key' => $this->google2fa->generateSecretKey(),
            ]
        );
    }

    /**
     * Generate QR Code for using in enable form view 
     * 
     * @return Array
     */
    public function generateQrCode(): Array
    {
        $google2fa_url = "";
        $user = Auth::user();
        if ($user->google2fa()->exists()) {
            $google2fa_url = $this->google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $user->google2fa->secret_key
            );
        }
        
        return [
            'user' => $user,
            'google2fa_url'=> $google2fa_url
        ];
    }

    /**
     * Enable Two FA
     * 
     * @param String $secretKey
     * @return bool
     */
    public function enable2fa(String $secretKey): bool
    {
        $user = Auth::user();
        $valid = $this->google2fa->verifyKey($user->google2fa->secret_key, $secretKey);
        if ($valid) {
            $user->google2fa->status = 1;
            $user->google2fa->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Disable Two FA
     * 
     * @param String $password
     * @return bool
     */
    public function disable2fa(String $password): bool
    {
        $user = Auth::user();
        if (!(Hash::check($password, $user->password))) {
            // The passwords matches
            return false;
        }

        $user->google2fa->status = 0;
        $user->google2fa->secret_key = null;
        $user->google2fa->save();
        return true;
    }
}

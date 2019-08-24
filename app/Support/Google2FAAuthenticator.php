<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthenticator extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    {
        if (!is_null($this->getUser()->google2fa))
            return true;
        return
            is_null($this->getUser()->google2fa) ? false : $this->getUser()->google2fa->status ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    protected function getGoogle2FASecretKey()
    {
        $secret = $this->getUser()->google2fa->{$this->config('otp_secret_column')};
        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }
        return $secret;
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleTwoFormRequest;
use App\Models\GoogleTwoFa;
use App\Services\GoogleTwoFaService;
use App\Services\RecoveryCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Auth;

class GoogleTwoFaController extends Controller
{
    /**
     * GoogleTwoFaService service object.
     *
     * @var GoogleTwoFaService
     */
    protected $googleTwoFaService;
    
    /**
     * RecoveryCodeService service object.
     *
     * @var RecoveryCodeService
     */
    protected $recoveryCodeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        GoogleTwoFaService $googleTwoFaService,
        RecoveryCodeService $recoveryCodeService
    ){
        $this->googleTwoFaService = $googleTwoFaService;
        $this->recoveryCodeService = $recoveryCodeService;
    }

    /**
     * GenerateQr code
     * 
     * @return View|RedirectResponse
     */
    public function enableForm()
    {
        if ($this->googleTwoFaService->generate2faSecret(Auth::user()) instanceof GoogleTwoFa) {
           $this->recovery = new \PragmaRX\Recovery();
            $this->recovery->toArray();
            
            $this->recoveryCodeService->generateRecoveryCode(Auth::user());
            return view('google2fa.enable', $this->googleTwoFaService->generateQrCode());
        } 
        
        return redirect('/')->with('error', "Oops Something went wrong, Please try again.");
    }    

    /**
     * Enable Two FA
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function enable2fa(Request $request): RedirectResponse
    {
        if ($this->googleTwoFaService->enable2Fa($request->input('verify-code'))) {
            return redirect('/')->with('status', "2FA is Enabled Successfully.");
        } else {
            return redirect('enable2fa')->with('error', "Invalid Verification Code, Please try again.");
        }
    }

    /**
     * Disable Two FA View
     * 
     * @return View
     */
    public function disableForm(): View
    {
        return view('google2fa.disable');
    }

    /**
     * Disable Two FA
     * 
     * @param GoogleTwoFormRequest $request
     * @return RedirectResponse
     */
    public function disable2fa(GoogleTwoFormRequest $request): RedirectResponse
    {
        if (!($this->googleTwoFaService->disable2Fa($request->input('current-password')))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your  password does not matches with your account password. Please try again.");
        }
        
        return redirect('/')->with('success', "2FA is now Disabled.");
    }
}
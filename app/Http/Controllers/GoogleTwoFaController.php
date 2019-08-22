<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleTwoFormRequest;
use App\Models\GoogleTwoFa;
use App\Services\GoogleTwoFaService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GoogleTwoFaController extends Controller
{
    /**
     * GoogleTwoFaService service object.
     *
     * @var GoogleTwoFaService
     */
    protected $googleTwoFaService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        GoogleTwoFaService $googleTwoFaService
    ){
        $this->googleTwoFaService = $googleTwoFaService;
    }

    /**
     * Generate & Store 2fa Secret key 
     * 
     * @return RedirectResponse
     */
    public function generate2faSecret(): RedirectResponse
    {
        if($this->googleTwoFaService->generate2faSecret() instanceof GoogleTwoFa) {
            return redirect('/enable2fa');
        }

        return redirect('/')->with('error', "Oops there is some error, please Try again");
    }

    /**
     * GenerateQr code
     * 
     * @return View
     */
    public function enableForm(): View
    {
        return view('google2fa.enable', $this->googleTwoFaService->generateQrCode());
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
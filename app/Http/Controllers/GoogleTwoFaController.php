<?php

namespace App\Http\Controllers;

use App\Models\GoogleTwoFa;
use Illuminate\Http\Request;
use Auth;
use Hash;
class GoogleTwoFaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\GoogleTwoFa  $googleTwoFa
     * @return \Illuminate\Http\Response
     */
    public function show(GoogleTwoFa $googleTwoFa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\GoogleTwoFa  $googleTwoFa
     * @return \Illuminate\Http\Response
     */
    public function edit(GoogleTwoFa $googleTwoFa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\GoogleTwoFa  $googleTwoFa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoogleTwoFa $googleTwoFa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\GoogleTwoFa  $googleTwoFa
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoogleTwoFa $googleTwoFa)
    {
        //
    }

    public function generate2faSecret(Request $request)
    {
        $user = Auth::user();
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Add the secret key to the registration data
        GoogleTwoFa::create([
            'user_id' => $user->id,
            'status' => 0,
            'secret_key' => $google2fa->generateSecretKey(),
        ]);

        return redirect('/enable2fa')->with('success', "Secret Key is generated, Please verify Code to Enable 2FA");
    }

    public function enableForm(Request $request)
    {
        $user = Auth::user();
        $google2fa_url = "";
        if ($user->google2fa()->exists()) {
            $google2fa = app('pragmarx.google2fa');
            $google2fa_url = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $user->google2fa->secret_key
            );
        }

        return view('google2fa.enable', [
            'user' => $user,
            'google2fa_url'=> $google2fa_url
        ]);
    }    

    public function enable2fa(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('verify-code');
        $valid = $google2fa->verifyKey($user->google2fa->secret_key, $secret);
        if ($valid) {
            $user->google2fa->status = 1;
            $user->google2fa->save();
            return redirect('/')->with('success', "2FA is Enabled Successfully.");
        } else {
            return redirect('enable2fa')->with('error', "Invalid Verification Code, Please try again.");
        }
    }

    public function disableForm() {
        return view('google2fa.disable');
    }

    public function disable2fa(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your  password does not matches with your account password. Please try again.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
        ]);
        $user = Auth::user();
        $user->google2fa->status = 0;
        $user->google2fa->save();
        return redirect('/')->with('success', "2FA is now Disabled.");
    }
}
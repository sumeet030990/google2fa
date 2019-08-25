@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Enable Two Fa Authentication</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also
                                referred to as factors) to verify your identity. Two factor authentication protects against
                                phishing, social engineering and password brute force attacks and secures your logins from
                                attackers exploiting weak or stolen credentials.
                            </p>
                            <div class="row">
                                <div class="col-md-6" style="text-align: center;">
                                    <strong>1. Scan this barcode with your Google Authenticator App:</strong><br />
                                    <img src="{{$google2fa_url }}" alt="">
                                </div>
                                <div class="col-md-6">
                                    <strong>2.Enter the pin the code to Enable 2FA</strong><br /><br />
                                    <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                            <label for="verify-code" class="col-md-4 control-label">Authenticator Code</label>
                                            <div class="col-md-6">
                                                <input id="verify-code" type="password" class="form-control" name="verify-code"
                                                    required>
                                                @if ($errors->has('verify-code'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('verify-code') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Enable 2FA
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Disable Two Fa Authentication</div>
                <div class="card-body">
                   <div class="alert alert-success">
                        2FA is Currently <strong>Enabled</strong> for your account.
                    </div>
                    <p>If you are looking to disable Two Factor Authentication. Please confirm your password and Click
                        Disable 2FA Button.</p>
                    <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <label for="change-password" class="col-md-4 control-label">Current Password</label>
                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control"
                                    name="current-password" required>
                                @if ($errors->has('current-password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('current-password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-5">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary ">Disable 2FA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
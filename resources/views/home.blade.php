@extends('layouts.app')

@section('content')
@php
    $googleTwoFaExists = is_null(Auth::user()->google2fa);   
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <p>Welcome, <b>{{Auth::user()->name}}</b></p>
                    <p> 
                        Your 2FA status is 
                        <span class="ml-3"> 
                            @if(!($googleTwoFaExists? false : Auth::user()->google2fa->status))
                                <button type="button" class="btn btn-danger" disabled>Disabled</button>
                            @else
                                <button type="button" class="btn btn-primary" disabled>Enabled</button>
                            @endif
                        </span>
                    </p>

                    <p class="pt-3">
                        <span>
                            @if(!($googleTwoFaExists ? false : Auth::user()->google2fa->status))
                                <a href="{{url('enable2fa')}}" class="btn btn-primary text-white">Enable Google2Fa</a>
                            @else
                                <button class="btn btn-warning" data-toggle="modal" data-target="#recoverCodeModal">Show Recovery code</button>
                                <a href="{{url('disable2fa')}}" class="btn btn-danger">Disable Google2Fa</a>
                            @endif
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('google2fa.recoveryCode')
@endsection

@extends('layouts.app')

@section('content')
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
                            @if(is_null(Auth::user()->google2fa) || !Auth::user()->google2fa->status)
                                <button type="button" class="btn btn-danger" disabled>Disabled</button>
                            @else
                                <button type="button" class="btn btn-primary" disabled>Enabled</button>
                            @endif
                        </span>
                    </p>

                    <p class="pt-3">
                        <span>
                            @if(is_null(Auth::user()->google2fa))
                                <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Generate Secret Key to Enable 2FA
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @elseif(!Auth::user()->google2fa->status)
                                <a href="{{url('enable2fa')}}" class="btn btn-primary text-white">Enable Google2Fa</a>
                            @else
                                <a class="btn btn-warning">Show Recovery code</a>
                                <a href="{{url('disable2fa')}}" class="btn btn-danger">Disable Google2Fa</a>
                            @endif
                        </span>
                    </p>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<style>
    :root {
        --dark: #1a1a2e;
        --dark-card: #1e2a4a;
        --gold: #d4a017;
        --text: #c8cdd8;
    }
    body { background: var(--dark); color: var(--text); font-family: 'Jost', sans-serif; }
    .auth-card {
        background: var(--dark-card);
        border: 1px solid rgba(212, 160, 23, 0.1);
        border-radius: 15px;
        padding: 40px;
        margin-top: 100px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .auth-header {
        font-family: 'Cormorant Garamond', serif;
        color: white;
        font-size: 32px;
        text-align: center;
        margin-bottom: 30px;
        letter-spacing: 2px;
    }
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(212, 160, 23, 0.2);
        color: white;
        border-radius: 8px;
        padding: 12px;
    }
    .form-control:focus {
        background: rgba(255,255,255,0.08);
        border-color: var(--gold);
        color: white;
        box-shadow: none;
    }
    .btn-register {
        background: linear-gradient(135deg, #d4a017, #f0d060);
        border: none;
        color: var(--dark);
        font-weight: 600;
        padding: 12px;
        border-radius: 50px;
        width: 100%;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .role-badge {
        display: block;
        text-align: center;
        color: var(--gold);
        font-size: 12px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
<input type="hidden" name="role" value="{{ request('role', 'member') }}">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

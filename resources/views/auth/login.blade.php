@extends('layouts.login')
@section('content')
<style>
    .alert-danger { color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    padding: 5px;}
    </style>
@if (session('message')) <div class="alert alert-danger"> {{ session('message') }} </div> @endif 
<form accept-charset="UTF-8" role="form" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="uk-form-group">
        <label class="uk-form-label"> Email</label>

        <div class="uk-position-relative w-100">
            <span class="uk-form-icon">
                <i class="icon-feather-mail"></i>
            </span>
            <input class="uk-input @error('email') is-invalid @enderror" name="email" type="email" placeholder="" value="{{ old('email') }}" autofocus> @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span> @enderror
        </div>

    </div>

    <div class="uk-form-group">
        <label class="uk-form-label"> Password</label>
        <div class="uk-position-relative w-100">
            <span class="uk-form-icon">
                <i class="icon-feather-lock"></i>
            </span>
            <input class="uk-input  @error('password') is-invalid @enderror" name="password" type="password" placeholder="" autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> @enderror
        </div>

    </div>

    <div class="uk-form-group">
        <label class="uk-form-label"> {{ __('Remember Me') }}</label>
        <div class="uk-position-relative w-100">
            <input class="form-check-input" type="checkbox" id="remember" {{ old( 'remember') ? 'checked' : '' }}>
        </div>

    </div>

    <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
        <div class="uk-width-auto@s">
            <button type="submit" class="button primary">Login</button>
        </div>
    </div>

    <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
        <div class="uk-width-expand@s">
            <p> Don't have an account?<a style="color:#8EC741;" href="register"> Sign up</a></p>
        </div>

    </div>

</form>
@endsection

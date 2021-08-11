@extends('layouts.app')
@include('layouts.css_material')
@section('content')
<div class="content-login">
    <div class="box-login">

        <div class="img-login">
            <div><a href="{{ url('/') }}"><img class="img-logo-login" src="/adminlte/img/GDSEC-font.png" alt=""></a></div>
        </div>
            <div class="form-login">
                <h6 style="text-align: center; font-size: 1.2em; font-weight: bold;">Iniciar Sesión</h6>
                <form id="loginForm" action="{{ route('login') }}" method="POST">
                     @csrf
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">

                            <input class="input-material @error('email') is-invalid @enderror" type="email" required class="form-control" id="email"
                                name="email" value="{{ old('email') }}"/>
                                <label class="label-material">{{__('Correo Electronico')}}</label>
                                {{-- <div class="bar"></div> --}}

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">

                            <input class="input-material @error('password') is-invalid @enderror" type="password" required class="form-control"
                                name="password" autocomplete="current-password" id="password"/>
                                <label class="label-material">{{ __('Contraseña')}}</label>
                                {{-- <div class="bar"></div> --}}

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-block btn-info btn-material"
                                style=" margin-bottom: 8px;">{{ __('Acceder') }}</button>
                            @if (Route::has('password.request'))
                                <a
                                    class="btn btn-link"
                                    href="{{ route('password.request') }}"
                                >
                                    {{ __("Forgot Your Password?") }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

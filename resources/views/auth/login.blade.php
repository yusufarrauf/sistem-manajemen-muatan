@extends('layouts.app')

@section('title', 'Login')
@section('body-class', 'hold-transition login-page')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>ANNISA RIZKI</b></a>
      </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login untuk masuk ke sistem</p>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="icheck-primary">
                            <input name="remember" id="remember" type="checkbox" id="remember">
                            <label for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Masuk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

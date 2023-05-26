@extends('tower::layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Авторизация</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('tower::innate::login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label @error('email') is-invalid @enderror">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row align-items-center row-cols-1 row-cols-md-2 gap-2 gap-md-0">
                                <div class="col flex-grow-1 order-2 order-md-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Запомнить меня</label>
                                    </div>
                                </div>
                                <div class="col col-md-auto order-1">
                                    <button type="submit" class="btn btn-primary w-100 px-4">Войти</button>
                                </div>
                            </div>

                            @if(Route::has('tower::innate::register') || Route::has('tower::innate::password-reset'))
                                <div class="row align-items-baseline mt-2">
                                    @if(Route::has('tower::innate::register'))
                                        <div class="col-auto">
                                            <a href="{{ route('tower::innate::register') }}">Зарегистрироваться</a>
                                        </div>
                                    @endif
                                    @if(Route::has('tower::innate::password-reset'))
                                        <div class="col-auto">
                                            <a href="{{ route('tower::innate::password-reset') }}">Восстановить пароль</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

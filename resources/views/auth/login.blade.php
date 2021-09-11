@extends('layouts.backend')
@section('body')

    <body class="login-bg">
        <div class="container flexbox flex-align-item flex-justify-center">
            <div class="login-screen">
                <form action="{{ 
                    route(
                        config(
                            'redprintUnity.login_post_route',
                            'backend.login.post'
                        )
                    ) }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="login-container">
                        <div class="login-box">
                            <div class="logo_login">
                                <div class="login-logo"><img src="{{ asset(config('redprintUnity.logo')) }}" alt="Backend" /></div>
                            </div>
                            @if ($errors->has('email') || $errors->has('password'))
                                <div class="alert alert-danger">メールとパスワードが一致しません。</div>
                            @endif
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="メールアドレス" aria-label="email" aria-describedby="email" name="email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="パスワード" aria-label="Password" aria-describedby="password" name="password">
                            </div>
                            @section('lost_password')
                            @show
                            <div class="buttons text-center">
                                <button type="submit" class="btn btn-primary btn-lg block">{{ trans('redprintUnity::core.login') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
@stop

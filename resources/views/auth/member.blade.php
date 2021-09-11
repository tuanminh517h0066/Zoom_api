@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 col-xs-12 show-desktop">
            <div class="content-login">
                <p><img src="/frontend/images/title-login.png" width="380" height="153" /></p>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 col-xs-12">
            <div class="block-login-frame">
                <h2 class="sub-title">ログイン</h2>
                <form action="{{route('login.post')}}" method="post">
                    {!! csrf_field() !!}

                    <fieldset class="fieldset">
                        @if ($errors->has('email') || $errors->has('password') || $errors->has('incorrect'))
                            <div class="alert alert-danger">メールとパスワードが一致しません。</div>
                        @endif

                        @if ($errors->has('inactive'))
                            <div class="alert alert-danger">このアカウントは停止されています。</div>
                        @endif

                        <div class="form-group">
                            <label class="control-label">メールアドレス</label>
                            <div class="field">
                                <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Eメール" required autofocus/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">パスワード</label>
                            <div class="field">
                                <input type="password" name="password" value="" placeholder="パスワード" class="form-control" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <input type="checkbox" name="remember" id="remember" placeholder="" {{ old('remember') ? 'checked' : '' }} />
                                    <label for="remember">ログインしたままにする</label>
                                </div>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ route('password.reset') }}" class="link-forgot-pas">パスワードを忘れた場合</a>
                            </div>
                        </div>
                    </fieldset>
                    <div class="buttons-set text-center">
                        <button type="submit" class="btn btn-primary btn-login"><span>ログインする</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
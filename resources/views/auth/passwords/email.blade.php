@extends('layouts.master')

@section('content')
<div class="container">
    <div class="col-sm-6 col-xs-12 col-sm-push-3">
        <div class="block-login-frame">
            <h2 class="sub-title">パスワード再発行の手続き</h2>
            <p>実践会に登録したメールアドレスを入力して下さい。パスワードを設定するためのURLをお送りします。</p>
            <form role="form" method="POST" action="{{ route('password.email') }}" enctype="multipart/form-data" class="margin-bt-35">
                {{ csrf_field() }}
                @if (session('status'))
                    <div class="alert alert-success">
                        ご入力頂いたメールアドレス宛にパスワード再発行のURLを記載したメールを送信致しました。
                    </div>
                @endif
                <fieldset class="fieldset">
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label">メールアドレス</label>
                        <div class="field">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Eメール" value="{{ old('email') }}" required/>
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>このメールアドレスが存在していません。</strong></span>
                            @endif
                        </div>
                    </div>
                </fieldset>
                <div class="buttons-set text-center">
                    <button type="submit" class="btn btn-primary btn-login submit"><span>送信</span></button>
                </div>
            </form>
            <p>すでにアカウントをお持ちですか? <a href="{{ route('login.form') }}" class="text-link">ログイン</a></p>
        </div>
    </div>
</div>
@stop
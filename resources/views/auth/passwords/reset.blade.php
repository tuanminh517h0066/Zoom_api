@extends('layouts.master')

@section('content')
<div class="container">
    <div class="col-sm-6 col-xs-12 col-sm-push-3">
        <div class="block-login-frame">
            <h2 class="sub-title">パスワード再発行の手続き</h2>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form role="form" method="POST" action="{{ route('password.reset') }}">
                {{ csrf_field() }}
                <fieldset class="fieldset">
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <input type="hidden" name="email" value="{{ $email }}" />
                    
                    @if ($errors->has('email'))
                    <div class="alert alert-danger">
                        <ul><li>{{ $errors->first('email') }}</li></ul>
                    </div>
                    @endif
                    
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="control-label">新しいパスワード</label>
                        <div class="input-field">
                            <input type="password" class="form-control" id="password" name="password" placeholder="新しいパスワード" required/>
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="control-label">新しいパスワード（確認用）</label>
                        <div class="input-field">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="新しいパスワード（確認用）" required/>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                            @endif
                            <span class="help-block"><strong>※パスワードは6文字以上でお願いします。</strong></span>
                        </div>
                    </div>
                </fieldset>

                <div class="buttons-set text-center">
                    <button type="submit" class="btn btn-primary btn-login submit">パスワードを再設定する</button>
                </div>
            </form>

        </div>
    </div>
</div>
@stop
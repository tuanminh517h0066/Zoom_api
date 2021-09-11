@extends('redprintUnity::page')

@section('title')
    Update Profile: {{$user->name}}
@stop

@section('page_title')
    プロフィール更新
@stop

@section('page_subtitle') 
    {{ $user->name }}
@stop

@section('page_icon') <i class="icon-user-circle"></i> @stop

@section('content')
<div class="card">

    <div class="card-body">
        <form action="{{ route('backend.profile.post') }}" method="POST" enctype="multipart/form-data" > 
            {!! csrf_field() !!}
            <fieldset>
                <input type="hidden" name="id" value="{{ $user->id }}" />
                <div class="row">
<!--
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" style="text-align: left;">姓<span class="required">*</span></label>

                            <input type="text" class="form-control" placeholder="姓" name="first_name" value="{{$user->first_name}}" />

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="control-label" style="text-align: left;">名<span class="required">*</span></label>

                        <input type="text" class="form-control" placeholder="名" name="last_name" value="{{$user->last_name}}" />

                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                </div>
-->
                <div class="row">
                    <div class="col-md-12">
                        <h5 style="padding-top: 25px; padding-left: 15px;">パスワード再設定:</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" style="text-align: left;">新しいパスワード</label>
                            <input type="password" class="form-control" placeholder="新しいパスワード" name="password"/>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" style="text-align: left;">新しいパスワード（確認用）</label>
                            <input type="password" class="form-control" placeholder="新しいパスワード（確認用）" name="password_confirmation"/>
                        </div>
                    </div>

                </div>

            </fieldset>

            <div class="card-footer text-center">
                @if(function_exists('redprint') && redprint() && $user->hasRole('su'))
                    <p>Super Users are not editable in Redprint mode.</p>
                @else
                    <button class="btn btn-primary btn-md btn-success" type="submit" style="border-radius: 0px !important;">保存</button>
                @endif
            </div>

        </form>

    </div>
</div>
@stop
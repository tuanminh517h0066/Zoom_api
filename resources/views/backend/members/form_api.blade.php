@extends(config('main-app-layout', 'redprintUnity::page'))

@section('title') Member - Form @stop

@section('page_title') 会員管理 @stop
@section('page_subtitle') @if ($member->exists) {{ trans('redprint::core.editing') }} 会員管理: {{ $member->last_name . $member->first_name }} @else 新規会員追加 @endif @stop

@section('title')
  @parent
  Member
@stop

@section('content')

  <form method="post" action="{{ route('member.api.save') }}" enctype="multipart/form-data" >
  {!! csrf_field() !!}
  <div class="card">

    <div class="card-body">
        <div class="form-group row has-feedback {{ $errors->has('user_last_name') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">姓</label>
            <div class="col-sm-10">
                <input type="text" name="user_last_name" class="form-control" value="{{ old('user_last_name') }}">
                @if ($errors->has('user_last_name'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('user_first_name') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">名</label>
            <div class="col-sm-10">
                <input type="text" name="user_first_name" class="form-control" value="{{ old('user_first_name') }}">
                @if ($errors->has('user_first_name'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>
        
        <div class="form-group row has-feedback {{ $errors->has('gender') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">性別</label>
            <div class="col-sm-10">
                <select class="form-control" name="gender">
                    <option value=""></option>
                    <option value="1">男</option>
                    <option value="2">女</option>
                </select>
                @if ($errors->has('gender'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('mail_address') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">Eメール</label>
            <div class="col-sm-10">
                <input type="text" name="mail_address" class="form-control" value="{{ old('mail_address') }}">
                @if ($errors->has('mail_address'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">パスワード</label>
            <div class="col-sm-10">
                <input type="text" name="password" class="form-control" value="{{ $member->password ?: old('password') }}">
                @if ($errors->has('password'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('registerd_date') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">入会日</label>
            <div class="col-sm-10">
                <input type="text" name="registerd_date" class="form-control" value="{{ old('registerd_date') }}">
                @if ($errors->has('registerd_date'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

    </div>

    <div class="card-footer">
      <div class="row">
        <div class="col-sm-12 text-center">
            <a href="{{ route('member.index') }}" class="btn btn-default">キャンセル</a>
          <button type="submit" class="btn-primary btn" >{{ trans('redprint::core.save') }}</button>
        </div>
      </div>
    </div>

  </div>
  </form>

@stop
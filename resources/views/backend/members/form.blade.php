@extends(config('main-app-layout', 'redprintUnity::page'))

@section('title') Member - Form @stop

@section('page_title') 会員管理 @stop
@section('page_subtitle') @if ($member->exists) {{ trans('redprint::core.editing') }} 会員管理: {{ $member->last_name . $member->first_name }} @else 新規会員追加 @endif @stop

@section('title')
  @parent
  Member
@stop

@section('content')

  <form method="post" action="{{ route('member.save') }}" enctype="multipart/form-data" >
  {!! csrf_field() !!}
  <div class="card">

    <div class="card-body">
        <input type="hidden" name="id" value="{{ $member->id }}" >
        <div class="form-group row has-feedback {{ $errors->has('last_name') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">姓</label>
            <div class="col-sm-10">
                <input type="text" name="last_name" class="form-control" value="{{ $member->last_name ?: old('last_name') }}">
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row has-feedback {{ $errors->has('first_name') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">名</label>
            <div class="col-sm-10">
                <input type="text" name="first_name" class="form-control" value="{{ $member->first_name ?: old('first_name') }}">
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-xs-12 col-sm-2">性別</label>
            <div class="col-sm-10">
                @php if ($member->gender) $gender = $member->gender; @endphp
                @php if (old('gender')) $gender = old('gender'); @endphp

                <select class="form-control" name="gender">
                    <option value="1" {{ (@$gender == 1) ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ (@$gender == 2) ? 'selected' : '' }}>女性</option>
                </select>
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">Eメール</label>
            <div class="col-sm-10">
                <input type="text" name="email" class="form-control" value="{{ $member->email ?: old('email') }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>

        @if(!$member->id)
        <div class="form-group row has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">パスワード</label>
            <div class="col-sm-10">
                <input type="text" name="password" class="form-control" value="{{ $member->password ?: old('password') }}">
                @if ($errors->has('password'))
                    <span class="help-block">
                        {{ $errors->first('password') }}
                    </span>
                @endif
                <span class="help-block"><strong>※パスワードは6文字以上でお願いします。</strong></span>
            </div>
        </div>
        @endif

        <div class="form-group row has-feedback {{ $errors->has('title') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">タイトル</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" value="{{ $member->title ?: old('title') }}">
                @if ($errors->has('title'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('intro') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">自己紹介</label>
            <div class="col-sm-10">
                <textarea name="intro" rows="5" class="form-control">{{ $member->intro ?: old('intro') }}</textarea>
                @if ($errors->has('intro'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('goal') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">ゴール</label>
            <div class="col-sm-10">
                <textarea name="goal" rows="5" class="form-control">{{ $member->goal ?: old('goal') }}</textarea>
                @if ($errors->has('goal'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('skill') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">スキル</label>
            <div class="col-sm-10">
                <textarea name="skill" rows="5" class="form-control">{{ $member->skill ?: old('skill') }}</textarea>
                @if ($errors->has('skill'))
                    <span class="help-block">
                        {{ trans('redprint::core.input_require') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback {{ $errors->has('avatar_image') ? 'has-error' : '' }}">

            <label class="control-label col-sm-2">{{ \Lang::has('redprint::strings.avatar_image') ? trans('redprint::strings.avatar_image') :  'アバター' }} </label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-default btn-file">
                            {{ trans('redprint::core.browse') }} <input type="file" class="imgInp" name="avatar_image">
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly>
                </div>
                
                <p class="txt-note" style="margin-left: 0px; margin-top: 5px;">最大アップロードサイズ：{{ ini_get('upload_max_filesize') }}B</p>

                <div class="flexbox">
                    <div class="img-thumb-default">
                        @if($member->avatar_image)
                            <img src="/uploads/members/{{ ($member->avatar_image) }}" class="img-thumbnail img-upload">
                        @else
                            <img src="/vendor/redprint/images/default-thumbnail.png" class="img-thumbnail img-upload">
                        @endif
                    </div>
                    <div class="txt-recommended">
                        <h5>推奨画像サイズ</h5>
                        - 縦: 120ピクセル<br />
                        - 横: 120ピクセル
                    </div>
                </div>

                @if($errors->has("avatar_image"))
                    <div class="help-block">{{ $errors->first('avatar_image') }}</div>
                @endif
            </div>

        </div>

        <div class="form-group row has-feedback {{ $errors->has('cover_image') ? 'has-error' : '' }}">
            <label class="control-label col-sm-2">{{ \Lang::has('redprint::strings.cover_image') ? trans('redprint::strings.cover_image') :  'カバー写真' }} </label>
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-btn">
                        <span class="btn btn-default btn-file">
                            {{ trans('redprint::core.browse') }} <input type="file" class="imgInp" name="cover_image">
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly>
                </div>
                
                <p class="txt-note" style="margin-left: 0px; margin-top: 5px;">最大アップロードサイズ：{{ ini_get('upload_max_filesize') }}B</p>
                <div class="flexbox">
                    <div class="img-thumb-default">
                        @if($member->cover_image)
                            <img src="/uploads/members/{{ ($member->cover_image) }}" class="img-thumbnail img-upload">
                        @else
                            <img src="/vendor/redprint/images/default-thumbnail.png" class="img-thumbnail img-upload">
                        @endif
                    </div>
                    <div class="txt-recommended">
                        <h5>推奨画像サイズ</h5>
                        - 縦: 675ピクセル<br />
                        - 横: 1920ピクセル
                    </div>
                </div>

                @if($errors->has("cover_image"))
                    <div class="help-block">{{ $errors->first('cover_image') }}</div>
                @endif

                @if($errors->has("cover_image"))
                    <div class="invalid-feedback">
                        {{ trans('redprint::core.input_require') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row has-feedback">
            <label class="col-sm-2">&nbsp;</label>
            <div class="col-sm-10">
                <label>
                    <input type="checkbox" name="role_create_knowhow" value="1" {!! ($member->role_create_knowhow || old('role_create_knowhow') == 1) ?'checked':'' !!}>
                    <span>ノウハウ投稿許可</span>
                </label>
            </div>
        </div>

        <div class="form-group row has-feedback">
            <label class="control-label col-sm-2">ランキング</label>
            <div class="col-sm-10">
                <span class="control-label" style="text-align: left; font-weight: normal;">{{ $ranking }}</span>
            </div>
        </div>

        <div class="form-group row has-feedback">
            <label class="control-label col-sm-2">実践報告を投稿した数  </label>
            <div class="col-sm-10">
                <span class="control-label" style="text-align: left; font-weight: normal;">{{ $practiceReportCount }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-sm-2 ">入会日</label>
            <div class="col-sm-10">
                <input class="form-control dateTime1" type="text" name="created_at" value="{{ $member->created_at ?: old('created_at') }}" id="created_at" data-toggle="datetimepicker" data-target="#created_at">
                <input type="hidden" name="created_time" value="{{ substr($member->created_at, 11, 8) }}">
              </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-xs-12 col-sm-2">ステータス</label>
            <div class="col-sm-10">
                @php if ($member->status) $status = $member->status; @endphp
                @php if (old('status')) $status = old('status'); @endphp

                <select class="form-control" name="status">
                    <option value="1" {{ (@$status == 1) ? 'selected' : '' }}>活動</option>
                    <option value="2" {{ (@$status == 2) ? 'selected' : '' }}>利用停止中</option>
                    <option value="3" {{ (@$status == 3) ? 'selected' : '' }}>退会</option>
                </select>
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

@section('post-js')
@parent
<script type="text/javascript">
$(document).ready(function(e){
    $('.dateTime1').datetimepicker({
       format: 'YYYY-MM-DD',
       locale: 'ja'
    });
});
</script>
@stop
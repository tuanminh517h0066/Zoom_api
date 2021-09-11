@extends(config('main-app-layout', 'redprintUnity::page'))

@section('title') Member - Index @stop

@section('page_title') 会員管理 @stop
@section('page_subtitle') Index @stop
@section('page_icon') <i class="icon-folder"></i> @stop

@section('content')
    <div class="card">

        <div class="card-header">
            <div class="form-group">
                <a href="{{ route('member.new') }}" class="btn btn-info" style="margin-right: 10px;"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;{{ trans('redprint::core.new') }}</a>
                @if(count(Request::input()))
                    <a class="btn btn-primary" href="{{ route('member.index') }}">{{ trans('redprint::core.clear') }}</a>
                    <a class="btn btn-primary" id="searchButton" data-toggle="modal" data-target="#searchModal" href="#">{{ trans('redprint::core.modify_search') }}</a>
                @else
                    <a class="btn btn-primary" id="searchButton" data-toggle="modal" data-target="#searchModal" href="#"><i class="icon-search"></i>&nbsp;&nbsp;{{ trans('redprint::core.search') }}</a>
                @endif
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group card-body" style="padding: 0px;">
                        <form name="frmcsv" method="post" action="{{ route('member.importcsv') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <div class="form-upload-file" style="display: inline-block; vertical-align: middle; margin-right: 5px;">
                                <div class="field">
                                    <label class="input-upload-file" style="margin-bottom: 0px; padding-top: 5px;padding-bottom: 5px;">
                                        <span><i class="fa fa-upload"></i> ファイルアップロード</span>
                                        <input type="file" name="csv_file" value="" class="input-file input-file-upload" accept=".csv" />
                                    </label>
                                </div>
                            </div>
                            <div style="display: inline-block; vertical-align: middle;">
                                <button disabled type="submit" class="btn btn-default" id="bt-update-status"><i class="fa fa-upload"></i>&nbsp;&nbsp;ユーザー情報一括更新</button>
                                <a href="{{ route('member.downloadcsv') }}" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i>&nbsp;&nbsp;サンプルのcsvファイルをダウンロードする</a>
                            </div>
                        </form>
                        <span id="show-input-file-csv" class="show-file-name" style="position: absolute; bottom: -24px; left: 0px; font-size: 14px;"></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <td>ユーザー名</td>
                        <td>Eメール</td>
                        <td>ステータス</td>
                        <td>入会日</td>
                        <th>{{ trans('redprint::core.actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($membersData as $memberItem)
                    <tr>
                        <td> {{ $memberItem->last_name . $memberItem->first_name }}</td>
                        <td> {{ $memberItem->email }}</td>
                        <td> 
                        @if ($memberItem->status == 1)
                            活動
                        @elseif ($memberItem->status == 2) 
                            利用停止中
                        @else
                            退会
                        @endif
                        </td>
                        <td> {{ substr($memberItem->created_at,0,10) }}</td>
                        <th>
                            @if(!$memberItem->deleted_at)
                                <a href="{{ route('member.form', $memberItem->id) }}" class="btn btn-default btn-xs"><span data-toggle="tooltip" data-placement="top" title="{{ trans('redprint::core.edit') }}"><i class="fa fa-edit"></i></span></a>
                                <!--
                                <a href="#" class="btn btn-xs btn-default" data-target="#deleteModal{{ $memberItem->id }}" data-toggle="modal" ><span data-toggle="tooltip" data-placement="top" title="{{ trans('redprint::core.delete') }}"><i class="fa fa-trash-alt"></i></span></a>
                                -->

                                <!-- modal starts -->
                                <div class="modal fade" id="deleteModal{{ $memberItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="form-horizontal" method="post" action="{{ route('member.delete', $memberItem->id) }}" >
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                                <h4 class="modal-title"> {{ trans('redprint::core.delete') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                                            </div>
                            
                                            <div class="modal-body">
                                                <h5>{{ trans('redprint::core.confirm_delete') }}</h5>
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('redprint::core.close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ trans('redprint::core.delete') }}</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal ends -->

                            @else

                                <a href="#" class="btn btn-xs btn-success" data-target="#restoreModal{{ $memberItem->id }}" data-toggle="modal" ><span data-toggle="tooltip" data-placement="top" title="Restore"><i class="fa fa-share"></i></span></a>
                                <a href="#" class="btn btn-xs btn-danger" data-target="#forceDeleteModal{{ $memberItem->id }}" data-toggle="modal" ><span data-toggle="tooltip" data-placement="top" title="{{ trans('redprint::core.permanently_delete') }}"><i class="fa fa-trash"></i></span></a>


                                <!-- modal starts -->
                                <div class="modal fade" id="restoreModal{{ $memberItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="form-horizontal" method="post" action="{{ route('member.restore', $memberItem->id) }}" >
                                            {!! csrf_field() !!}

                                            <div class="modal-header">
                                                <h4 class="modal-title"> {{ trans('redprint::core.restore') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                                            </div>
                            
                                            <div class="modal-body">
                                                {{ trans('redprint::core.confirm_restore') }} <code>{{ $memberItem->last_name . $memberItem->first_name }} ?</code>
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('redprint::core.close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ trans('redprint::core.restore') }}</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal ends -->



                                <!-- modal starts -->
                                <div class="modal fade" id="forceDeleteModal{{ $memberItem->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="form-horizontal" method="post" action="{{ route('member.force-delete', $memberItem->id) }}" >
                                            {!! csrf_field() !!}
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Permanently </h4>
                                                <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                                            </div>
                            
                                            <div class="modal-body">
                                                {{ trans('redprint::core.confirm_permanent_delete') }} <strong>{{ $memberItem->last_name . $memberItem->first_name }} </strong> ? {{ trans('redprint::core.permanent_delete_warning') }}
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('redprint::core.close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ trans('redprint::core.permanently_delete') }}</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal ends -->

                            @endif
                        </th>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $membersData->appends(request()->except('page'))->links() }} 
        </div>
    </div>

    @section('modals')
    @parent
    <!-- member search modal -->
    <div class="modal fade" id="searchModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="get" action="{{ route('member.index') }}" >
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('redprint::core.search') }}</h4>
                    <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                </div>

                <div class="modal-body">         
                    <div class="form-group">
                        <label class="control-label">会員番号</label>
                        <div class="input-field">
                            <input type="text" name="member_id" value="{{ app('request')->input('member_id') }}" class="form-control" >
                        </div>
                    </div> 
                             
                    <div class="form-group">
                        <label class="control-label">名前</label>
                        <div class="input-field">
                            <input type="text" name="name" value="{{ app('request')->input('name') }}" class="form-control" >
                        </div>
                    </div>    

                    <div class="form-group">
                        <label class="control-label">Eメール</label>
                        <div class="input-field">
                            <input type="input" name="email" value="{{ app('request')->input('email') }}" class="form-control" >
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="control-label">実践報告数</label>
                        <div class="input-field">
                            <input type="number" name="number_practice" value="{{ app('request')->input('number_practice') }}" class="form-control" >
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="control-label">ランク</label>
                        <div class="input-field">
                            <input type="number" name="number_ranking" value="{{ app('request')->input('number_ranking') }}" class="form-control">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label class="control-label">ステータス</label>
                        <div class="input-field">
                            @php $status = app('request')->input('status'); @endphp
                            <select class="form-control" name="status">
                                <option value=""}}>--選択する--</option>
                                <option value="1" {{ (@$status == 1) ? 'selected' : '' }}>活動</option>
                                <option value="2" {{ (@$status == 2) ? 'selected' : '' }}>利用停止中</option>
                                <option value="3" {{ (@$status == 3) ? 'selected' : '' }}>退会</option>
                            </select>
                        </div>
                    </div> 
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('redprint::core.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('redprint::core.search') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- search modal ends -->

    <!-- modal starts -->
    <div class="modal fade" id="changeStatusModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" method="post" action="{{ route('member.change-status') }}" >
                {!! csrf_field() !!}
                <div class="modal-header">
                    <h4 class="modal-title"> Change Status </h4>
                    <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                </div>

                <div class="modal-body">
                    Do you make sure change status?
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="status_action" value="">
                    <input type="hidden" name="member_id_list" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('redprint::core.close') }}</button>
                    <button type="submit" class="btn btn-primary">Ok</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal ends -->
    @stop

@stop

@section('post-js')
@parent
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
/*
    $('.chk_member_id, .status_option, #chkAll').change(function() {
        var status = $('.status_option').val();

        if($('.chk_member_id:checkbox:checked').length > 0 && status != 0) {
            $('#change_status').removeAttr('disabled');
        } else {
            $('#change_status').attr('disabled', 'disabled');
        }
    });

    $("#chkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('#change_status').click(function() {
        var status = $('.status_option').val();
        var member_id_list=[];

        $(".chk_member_id:checked").each(function() {
            member_id_list.push($(this).val());
        });

        if(status == 0) {
            return;
        }

        $('input[name="status_action"]').val(status);
        $('input[name="member_id_list"]').val(member_id_list);

        $.ajax({
            url: 'members/change-status',
            data: {
                member_id_list: member_id_list,
                status: status
            },
            type: 'post',
            success: function() {
                //location.reload();
            }
        });
    });
*/

    // Get File Name
    $(document).on('change', '.input-file-upload', function () {
        $('#show-input-file-csv').text(this.files[0].name);
        $('#bt-update-status').removeClass('btn-default');
        $('#bt-update-status').addClass('btn-primary');
        $('#bt-update-status').removeAttr('disabled');
    });

    $(document).on('click', '.delete_default_file_knowhow', function () {
        //$('#multiUploadFiles input[name="file_name1"]').val('');
        //$(this).parents('#input-file-1').html('');
    });
});
</script>
@stop
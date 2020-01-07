@extends('layouts.template')
@section('extra-css')
<link href="{{asset('plugin/jquery-3.1.1/sweetalert.min.js')}}" rel="stylesheet" />
@endsection

@section('page_contents')
<div id="page_monitoring_report_import">

    <div id="action">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    {{-- <div class="col-sm-2">
                        <i class="icon-settings"></i>
                        &nbsp;
                        &nbsp;
                        Upload
                    </div> --}}
                    <div class="col-sm-2">
                            <span class="btn btn-clear">
                            <i class="icon-cloud-upload"></i>
                                &nbsp;
                                &nbsp;
                            Upload</span>
                        </div>
                    <div class="pull-right col-sm-3">
                        <a href="{{ url('/drama_template.xls') }}"
                        <span class="btn btn-success btn-sm">
                        <i class="icon-doc"></i>
                            &nbsp;
                            &nbsp;
                        Download Excel Format</span></a>
                    </div>
                </div>
            </div>
            
            <div class="panel-body">
                <form method="post" action="{{ route('system.upload') }}" accept-charset="UTF-8" autocomplete="off"
                    enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">
                                    Date <sup>(Required)</sup>
                                </label>
                                <input name="date" type="text" id="datepicker" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="form-label">
                                    Sumber <sup>(Required)</sup>
                                </label>
                                <input name="source" type="text" id="datepicker" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">
                                    File
                                </label>
                                <div id="monitoring_report_import_file_input">
                                    <div class="input-group">
                                        <input id="my_file" type="file" name="file" style="display:none; data-url="{{ url('system/upload') }}""
                                            accept=".xls, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                            required>
                                        <input id="file_name" type="text" class="form-control" readonly="true">
                                        <span id="show" class="input-group-addon" title="File">
                                            <i id="get_file" class="icon-folder"></i>
                                        </span>
                                        <span id="clear" class="input-group-addon clear" title="Hapus">
                                            <i class="icon-trash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span id="file_progress" class="float-left"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="pull-right btn btn-hive import">
                                <i class="icon-cloud-upload"></i>
                                &nbsp;
                                &nbsp;
                                Upload
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <br />
    <div id="record">
        <div class="panel">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="40">No.</th>
                        <th width="100">
                            Status
                        </th>
                        <th width="100">
                            Sub
                        </th>
                        <th width="100">
                            Tipe
                        </th>
                        <th width="200">Tanggal</th>
                        <th width="300">File</th>
                        <th width="210" colspan="2">
                            <center><i class="icon-settings"></i></center>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @if($records->count() > 0)
                    @foreach($records as $index => $record)
                    <tr>
                        <td>
                            {{++$index}}
                        </td>
                        <td>
                            @if($record->status->id == 1)
                            <div class="status draft">
                                @elseif($record->status->id == 2)
                                <div class="status active">
                                    @else
                                    <div class="status draft">
                                        @endif
                                        <center>{{$record->status->status_name}}</center>
                                    </div>
                        </td>
                        <td>
                            {{ $record->language->language_name }}
                        </td>
                        <td>
                            {{$record->type->name}}
                        </td>
                        <td>
                            {{ $record->created_at }}
                        </td>
                        <td>
                            <div class="file">
                                {{$record->filename}}
                            </div>
                        </td>
                        @if($record->status->isStatusDraft())
                        <td>
                            @if($record->type->id == \App\XlsFileType::TYPE_SERIES)
                            <form method="post" action="{{ route('system.insertDrama') }}" accept-charset="UTF-8"
                                autocomplete="off">
                                {{csrf_field()}}
                                <input type="hidden" name="xls_id" value="{{ $record->id }}">
                                <input type="hidden" name="language_id" value="{{ $record->language_id }}">
                                <button type="submit" class="btn btn-sm btn-white process">
                                    <i class="icon-login"></i>
                                    &nbsp;
                                    Proses
                                </button>
                            </form>
                            @else 
                            <form method="post" action="{{ route('system.insertMovie') }}" accept-charset="UTF-8"
                                autocomplete="off">
                                {{csrf_field()}}
                                <input type="hidden" name="xls_id" value="{{ $record->id }}">
                                <input type="hidden" name="language_id" value="{{ $record->language_id }}">
                                <button type="submit" class="btn btn-sm btn-white process">
                                    <i class="icon-login"></i>
                                    &nbsp;
                                    Proses
                                </button>
                            </form>
                            @endif
                        </td>
                        <td>
                            <form method="post" action="{{ route('system.removeDraft') }}" accept-charset="UTF-8"
                                autocomplete="off">
                                {{csrf_field()}}
                                <input type="hidden" name="xls_id" value="{{ $record->id }}">
                                <button type="submit" class="btn btn-sm btn-white process">
                                    <i class="icon-trash"></i>
                                    &nbsp;
                                    Delete Draft
                                </button>
                            </form>
                        </td>
                        @elseif($record->status->isStatusActive())
                        <td colspan="2">
                            <center>
                            @if($record->type->id == \App\XlsFileType::TYPE_SERIES)
                            <a href="{{url('/system/dramas')}}" class="btn btn-sm btn-white">
                                <i class="icon-list"></i>
                                &nbsp;
                                Tampilkan
                            </a>
                            </center>
                            @else 
                            <center>
                            <a href="{{url('/system/movies')}}" class="btn btn-sm btn-white">
                                <i class="icon-list"></i>
                                &nbsp;
                                Tampilkan
                            </a>
                            </center>
                            @endif
                        </td>
                        {{-- <td colspan="2" align="center">
                            <form method="post" action="{{ route('system.removeDraft') }}" accept-charset="UTF-8"
                                autocomplete="off">
                                {{csrf_field()}}
                                <input type="hidden" name="xls_id" value="{{ $record->id }}">
                                <button type="submit" class="btn btn-sm btn-white process">
                                    <i class="icon-trash"></i>
                                    &nbsp;
                                    Delete
                                </button>
                            </form>
                        </td> --}}
                        @else
                        <td colspan="2" align="center">
                            <form method="post" action="{{ route('system.insertDrama') }}" accept-charset="UTF-8"
                                autocomplete="off">
                                {{csrf_field()}}
                                <input type="hidden" name="xls_id" value="{{ $record->id }}">
                                <input type="hidden" name="language_id" value="{{ $record->language_id }}">
                                <button type="submit" class="btn btn-sm btn-white process">
                                    <i class="icon-reload"></i>
                                    &nbsp;
                                    Re-Process
                                </button>
                            </form>
                        </td>
                        {{-- <td colspan="2" align="center">
                            <form method="post" action="{{ route('system.removeDraft') }}" accept-charset="UTF-8"
                                autocomplete="off">
                                {{csrf_field()}}
                                <input type="hidden" name="xls_id" value="{{ $record->id }}">
                                <button type="submit" class="btn btn-sm btn-white process">
                                    <i class="icon-trash"></i>
                                    &nbsp;
                                    Delete
                                </button>
                            </form>
                        </td> --}}
                        @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7">
                            <center>
                                <i class="icon-drawer"></i>
                            </center>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>


</div>
@endsection
@section('extra-js')
<script src="{{asset('plugin/jquery-3.1.1/jquery.bsAlert.min.js')}}"></script>
<script src="{{asset('plugin/jquery-3.1.1/sweetalert.min.js')}}"></script>
<script src="{{asset('plugin/jquery-3.1.1/jquery.ui.widget.js')}}"></script>
<script src="{{asset('plugin/jquery-3.1.1/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('plugin/jquery-3.1.1/jquery.fileupload.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.2/plupload.full.min.js"></script>

<script>
    $(function () {
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            maxDate: 0,
            changeYear: true
        });
    });
</script>
<script>
    document.getElementById('show').onclick = function () {
        document.getElementById('my_file').click();
    };

    $('input[type=file]').change(function (e) {
        $('#file_name').val($(this).val());
    });
</script>

<script>
    
</script>
<script>
    document.getElementById('clear').onclick = function () {
        document.getElementById("file_name").value = "";
        document.getElementById("my_file").value = "";
    };
</script>
@endsection
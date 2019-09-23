@extends('layouts.template')
@section('extra-css')
<link href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

@endsection

@section('page_contents')
<div id="page_monitoring_report">
    <div id="record">
        <div class="panel panel-primary">
            <div class="content-body">
                <div class="box">
                    <div id="action">
                        <br />
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="txt_search" class="form-control" placeholder="&#xF002; SEARCH"
                                    style="font-family:Arial, FontAwesome" />

                                <span id="clear_search" class="input-group-addon" title="Clear">
                                    <i class="icon-close"></i>
                                </span>
                            </div>

                        </div>
                        <div class="pull-right col-sm-2">
                            <div class="input-group">
                                <a href="{{ url('system/createGenre') }}" class="btn btn-sm btn-success">
                                    <i class="icon-plus"></i>
                                    &nbsp;&nbsp;&nbsp;
                                    Tambah
                                </a>
                            </div>

                        </div>

                        <div class="row">

                        </div>
                    </div>
                    <br />
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table id="table_genres" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10">NO</th>
                                    <th width="700">Nama Genre</th>
                                    <th colspan="2" align="center">
                                        <center><i class="icon-settings"></i></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_record">
                                @foreach ($records as $i => $record)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $record->name }}</td>
                                    <td>
                                        <a href="{{ route('system.editGenre', $record->id) }}"
                                            class="btn btn-sm btn-white process">
                                            <i class="icon-note"></i>
                                            &nbsp;
                                            Edit
                                        </a>
                                        <a href="{{ route('system.deleteGenre', $record->id) }}"
                                            class="btn btn-sm btn-white process">
                                            <i class="icon-trash"></i>
                                            &nbsp;
                                            Delete
                                        </a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <br />

                <br />
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
<script>
    $(function () {
        oTable = $('#table_genres').DataTable({
            "paging": false,
            "ordering": true,
            "searching": true,
            "bInfo": false,
            "sDom": "ltipr"
        });
    });
    $('#txt_search').keyup(function () {
        oTable.search($(this).val()).draw();
    });
    $('#clear_search').click(function () {
        document.getElementById("txt_search").value = "";
        oTable.search('').columns().search('').draw();
    });
</script>
@endsection
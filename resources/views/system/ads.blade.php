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
                            

                        </div>
                        <div class="pull-right col-sm-2">
                            <div class="input-group">
                                <a href="{{ url('system/createAds') }}" class="btn btn-sm btn-success">
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
                                    <th width="150">Judul</th>
                                    <th width="200">Deskripsi</th>
                                    <th width="150">Gambar</th>
                                    <th width="150">Url</th>
                                    <th width="200" align="center">
                                        <center><i class="icon-settings"></i></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_record">
                                @foreach ($records as $i => $record)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $record->title }}</td>
                                    <td>{{ $record->description }}</td>
                                    <td>{{ $record->image }}</td>
                                    <td>{{ $record->url }}</td>
                                    <td>
                                        <a href="{{ route('system.updateAds', $record->id) }}"
                                            class="btn btn-sm btn-white process">
                                            <i class="icon-note"></i>
                                            &nbsp;
                                            Edit
                                        </a>
                                        <a href="{{ route('system.deleteAds', $record->id) }}"
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')

@endsection
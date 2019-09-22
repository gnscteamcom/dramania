@extends('layouts.template')
@section('page_contents')
<div id="page_dashboard">
    <div id="monitoring">
        <div class="row">
            <div class="col-md-4">
                <div class="tile indigo">
                    <div class="icon">
                        <i class="fa fa-file-image" style="font-size: 88px; color: #fff"></i>
                    </div>
                    <div class="value">
                        <div class="count">
                            {{ $ids->count() + $ens->count() }}
                        </div>
                        <div class="title">
                            ALL DRAMA
                        </div>
                    </div>
                    <div class="action">
                        <a href="">
                            Tampilkan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="tile teal">
                    <div class="icon">
                        <i class="fa fa-language" style="font-size: 88px; color: #fff"></i>
                    </div>
                    <div class="value">
                        <div class="count">
                            {{ $ids->count() }}
                        </div>
                        <div class="title">
                            SUB INDO
                        </div>
                    </div>
                    <div class="action">
                        <a href="">
                            Tampilkan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="tile red">  
                    <div class="icon">
                        <i class="fa fa-language" style="font-size: 88px; color: #fff"></i>
                    </div>
                    <div class="value">
                        <div class="count">
                            {{ $ens->count() }}
                        </div>
                        <div class="title">
                            SUB ENGLISH
                        </div>
                    </div>
                    <div class="action">
                        <a href="">
                            Tampilkan
                        </a>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-3">
                <div class="tile indigo">
                    <div class="icon">
                        <i class="fa fa-user-tie" style="font-size: 88px; color: #fff"></i>
                    </div>
                    <div class="value">
                        <div class="count">
                            {{ $bri->count() }}
                        </div>
                        <div class="title">
                            DEC BRI
                        </div>
                    </div>
                    <div class="action">
                        <a href="">
                            Tampilkan
                        </a>
                    </div>
                </div>
            </div> --}}
        </div>

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
                                    <th width="200">Tanggal</th>
                                    <th width="400">File</th>
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
                                                <div class="status deleted">
                                                    @endif
                                                    <center>{{$record->status->status_name}}</center>
                                                </div>
                                    </td>
                                    <td>
                                        {{ $record->language->language_name }}
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
                                        <form method="post" action="{{ route('system.insertManga') }}" accept-charset="UTF-8"
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
                                    <td colspan="2" align="center">
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
                                    </td>
                                    @else
                                    <td colspan="2" align="center">
                                            <form method="post" action="{{ route('system.insertManga') }}" accept-charset="UTF-8"
                                            autocomplete="off">
                                            {{csrf_field()}}
                                            <input type="hidden" name="xls_id" value="{{ $record->id }}">
                                            <input type="hidden" name="language_id" value="{{ $record->language_id }}">
                                            <button type="submit" class="btn btn-sm btn-white process">
                                                <i class="icon-trash"></i>
                                                &nbsp;
                                                Re-Process
                                            </button>
                                        </form>
                                    </td>
                                    <td colspan="2" align="center">
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
                                    </td>
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


</div>
@endsection
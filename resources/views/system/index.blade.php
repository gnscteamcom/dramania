@extends('layouts.template')
@section('page_contents')
<div id="page_dashboard">
    <div id="monitoring">
        <div class="row">
            <div class="col-md-4">
                <div class="tile indigo">
                    <div class="icon">
                        <i class="icon-film" style="font-size: 88px; color: #fff"></i>
                    </div>
                    <div class="value">
                        <div class="count">
                            {{ $movies->count()}}
                        </div>
                        <div class="title">
                            MOVIES
                        </div>
                    </div>
                    <div class="action">
                        <a href="{{route('system.movies')}}">
                            Show
                        </a>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="tile red">  
                    <div class="icon">
                        <i class="icon-tag" style="font-size: 88px; color: #fff"></i>
                    </div>
                    <div class="value">
                        <div class="count">
                            {{ $genres->count() }}
                        </div>
                        <div class="title">
                            GENRES
                        </div>
                    </div>
                    <div class="action">
                        <a href="{{route('system.genres')}}">
                            Show
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="tile indigo">
                    <div class="icon">
                        <i class="icon-doc" style="font-size: 88px; color: #fff"></i>
                    </div>
                    <div class="value">
                        <div class="count">
                            {{ $records->count() }}
                        </div>
                        <div class="title">
                            FILES
                        </div>
                    </div>
                    <div class="action">
                        <a href="">
                            Show
                        </a>
                    </div>
                </div>
            </div> 
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
                                    <th width="100">
                                        Tipe
                                    </th>
                                    <th width="200">Tanggal</th>
                                    <th width="400">File</th>
                                    {{-- <th width="210" colspan="2">
                                        <center><i class="icon-settings"></i></center>
                                    </th> --}}
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
                                        {{ $record->type->name }}
                                    </td>
                                    <td>
                                        {{ $record->created_at }}
                                    </td>
                                    <td>
                                        <div class="file">
                                            {{$record->filename}}
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6">
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
@extends('layouts.template')
@section('extra-css')
<link rel="stylesheet" type="text/css" href="{{asset('css/page_master_user_admin.css')}}">

@endsection
@section('page_contents')
<div id="page_master_user_admin">

    <div class="panel">
        <div class="panel-heading">
            <i class="icon-settings"></i>
            &nbsp;
            &nbsp;
            &nbsp;
            EDIT {{ strtoupper($record->title) }}
        </div>
        <div class="panel-body">
            <form method="post" action="{{ route('system.editGenrePost', $record) }}" accept-charset="UTF-8"
                autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">
                                NAMA GENRE
                            </label>
                            <input required type="text" name="name" class="form-control" value="{{old('name', $record->name)}}">
                        </div>
                    </div>
                    

                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button style="padding:11px;" type="submit" class="pull-right btn btn-hive">
                            <i class="icon-check"></i>
                            &nbsp;
                            &nbsp;
                            Simpan
                        </button>
                        &emsp;&nbsp;
                        <a href="{{url()->previous()}}" class="pull-right btn btn-white back">
                            <i class="icon-action-undo"></i>
                            &nbsp;
                            &nbsp;
                            Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
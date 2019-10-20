@extends('layouts.template')
@section('extra-css')
<link rel="stylesheet" type="text/css" href="{{asset('css/page_master_user_admin.css')}}">

@endsection
@section('page_contents')
<div id="page_master_user_admin">

    <div class="panel">
        <div class="panel-heading">
            <i class="icon-present"></i>
            &nbsp;
            &nbsp;
            &nbsp;
            Iklan
        </div>
        <div class="panel-body">
            <form method="post" action="{{ route('system.createAdsPost') }}" accept-charset="UTF-8" autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                TITLE
                            </label>
                            <input required type="text" name="title" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                URL
                            </label>
                            <input required type="text" name="url" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                GAMBAR
                            </label>
                            <input required type="text" name="image" class="form-control"">
                        </div>
                    </div>
                </div>
                <div class=" row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        DESCRIPTION
                                    </label>
                                    <textarea rows="3" required type="text" name="description" class="form-control">

                                    </textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <button style="margin-left:8px;padding:11px;" type="submit"
                                    class="pull-right btn btn-hive">
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
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
            <form method="post" action="{{ route('system.editDramaPost', $record) }}" accept-charset="UTF-8"
                autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                Bahasa
                            </label>
                            <select class="form-control" name="language_id">
                                @foreach($languages as $lang)
                                <option value="{{$lang->id}}">
                                    {{$lang->language_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                TITLE
                            </label>
                            <input required type="text" name="title" class="form-control" value="{{old('title', $record->title)}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                AUTHOR
                            </label>
                            <input required type="text" name="author" class="form-control" value="{{old('author', $record->author)}}">
                            @if ($errors->has('author'))
                            <div class="form-control-feedback-message">
                                <font color="red">The username is already been taken!</font>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                POSTER
                            </label>
                            <input required type="text" name="poster" class="form-control" value="{{old('poster', $record->poster)}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label">
                                STATUS
                            </label>
                            <input required type="text" name="status" class="form-control" value="{{old('status', $record->status)}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">
                                    RATING
                                </label>
                                <input required type="text" name="rating" class="form-control" value="{{old('rating', $record->rating)}}">
                            </div>
                        </div>

                        <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        DESCRIPTION
                                    </label>
                                    <textarea rows="5" required type="text" name="description" class="form-control">
                                            {{old('description', $record->description)}}
                                    </textarea>
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
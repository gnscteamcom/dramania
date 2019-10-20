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
            TAG
        </div>
        <div class="panel-body">
            <form method="post" action="{{ route('system.createTagPost') }}" accept-charset="UTF-8"
                autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">
                                DRAMA
                            </label>
                            <select required type="text" name="dramaId" class="search form-control"></select>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Tags</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="40">No.</th>
                                            <th>Tag Name</th>
                                            <th width="40">
                                                <center><i class="icon-settings"></i></center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tags as $i => $tag)
                                        <tr>
                                            <td>{{ $i + 1}}</td>
                                            <td>{{ $tag->name }}</td>
                                            <td>
                                                <center>
                                                    <input type="checkbox" name="tags[]"
                                                        value="{{ $tag->id }}" class="tag">
                                                </center>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
    
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button style="margin-left:8px;padding:11px;" type="submit" class="pull-right btn btn-hive">
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

@section('extra-js')
<script type="text/javascript">
$('.search').select2({
    placeholder: 'Search...',
    ajax: {
      url: '{{ url("system/searchDrama") }}',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.title,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

</script>
@endsection
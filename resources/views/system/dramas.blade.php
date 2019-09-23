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

                        <div class="col-sm-2">
                            {{-- @if($record->hasPages) --}}
                            <div class="pages"><span class="name"></span>
                                @if( $records->currentPage() !==1 )
                                <a class="prev" href="?page={{ $records->currentPage() -1 }}">&lt;</a>
                                @else
                                @endif
                                <span class="numb">{{ $records->currentPage() }}</span><a class="next"
                                    href="?page={{ $records->currentPage() +1 }}">&gt;</a>
                            </div>
                            {{-- @else --}}
                            {{-- @endif --}}
                        </div>
                        <div class="col-sm-4">
                        <form method="get" accept-charset="UTF-8" autocomplete="off">
                            <div class="input-group">
                                <input type="text" id="txt_search" class="form-control" placeholder="&#xF002; SEARCH"
                                    style="font-family:Arial, FontAwesome" name="title" />

                                <span id="clear_search" class="input-group-addon" title="Clear">
                                    <i class="icon-close"></i>
                                </span>
                            </div>
                        </form>
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
                                    <th width="35">POSTER</th>
                                    <th>TITLE</th>
                                    <th>STATUS</th>
                                    <th>DESCRIPTION</th>
                                    <th>AUTHOR</th> 
                                    <th>RATING</th>
                                    <th>DRAMA</th>
                                    <th align="center">
                                        <center><i class="icon-settings"></i></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_record">
                                @foreach ($records as $i => $record)
                                <tr>
                                    <td>{{ $i+ $records->firstItem() }}</td>
                                    <td><center><a href="{{ $record->poster }}" target="_blank"><img src="{{ $record->poster }}"
                                        height="50px;" width="30px"></a></center></td>
                                    <td>{{ $record->title }}</td>
                                    <td>{{ $record->status }}</td>
                                    <td>{{ str_limit($record->description, $limit = 50, $end = '...') }}</td>
                                    <td>{{ $record->author }}</td>
                                    <td>{{ $record->rating }}</td>
                                    <td>{{ $record->language->language_name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button action="javascript:;"
                                                class="btn btn-sm btn-white clear dropdown-toggle"
                                                data-toggle="dropdown">
                                                <i class="icon-list"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    
                                                    <a href="{{url('system/editDrama', $record->id)}}">
                                                        <i class="icon-note"></i>
                                                        &nbsp;&nbsp;&nbsp;
                                                        Edit
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

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
    $('#clear_search').click(function () {
        document.getElementById("txt_search").value = "";
        oTable.search('').columns().search('').draw();
    });
</script>

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



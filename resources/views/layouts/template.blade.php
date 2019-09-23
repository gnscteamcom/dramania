<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>DRAMANIA - MANTAP!</title>

    <link rel="stylesheet" type="text/css" href="{{asset('plugin/simple-line-icons-webfont/simple-line-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/bootstrap-3.3.7/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/jquery-3.1.1/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/jquery-3.1.1/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/rvnm/jquery-rvnm.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/load-awesome-1.1.0/la-ball-clip-rotate.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('plugin/jquery-file-upload-9.18.0/css/jquery.fileupload.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('plugin/fontawesome-free-5.10.1/css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/file_import.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/import_file.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/import_file_input.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dashboard.css')}}">

    @yield('extra-css')
</head>

<body id="page" class="page_sidebar_blue">
    @include('layouts.partials._navigation')
    <div id="page_container">
        @include('layouts.partials._header')
        <div id="page_contents">
            @yield('page_contents')
        </div>

    </div>

    <script src="{{asset('plugin/jquery-3.1.1/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('plugin/jquery-3.1.1/jquery-ui.js')}}"></script>
    <script src="{{asset('plugin/jquery-3.1.1/select2.min.js')}}"></script>
    <script src="{{asset('plugin/jquery-3.1.1/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugin/bootstrap-3.3.7/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('plugin/bootstrap-3.3.7/js/bootstrap3-typeahead.min.js')}}"></script>
    <script src="{{asset('plugin/amd-1.0/amd.min.js')}}"></script>
    <script src="{{asset('plugin/rvnm/rvnm.min.js')}}"></script>
    <script src="{{asset('js/global.js')}}"></script>
    <script src="{{asset('js/layout.js')}}"></script>
    {{-- <script src="{{asset('js/dashboard.js')}}"></script> --}}
    <script src="{{asset('plugin/highcharts-4.2.3/js/highcharts.js')}}"></script>
    <script src="{{asset('plugin/highcharts-4.2.3/js/modules/exporting.js')}}"></script>
    <script src="{{asset('plugin/jquery-file-upload-9.18.0/js/vendor/jquery.ui.widget.js')}}"></script>
    <script src="{{asset('plugin/jquery-file-upload-9.18.0/js/jquery.fileupload.js')}}"></script>
    <script src="{{asset('plugin/jquery-file-upload-9.18.0/js/jquery.fileupload-process.js')}}"></script>
    <script src="{{asset('plugin/jquery-file-upload-9.18.0/js/jquery.fileupload-validate.js')}}"></script>
    <script src="{{asset('js/event.js')}}"></script>
    <script src="{{asset('js/import_file.js')}}"></script>
    <script src="{{asset('js/file_input.js')}}"></script>
    <script src="{{asset('js/file_import.js')}}"></script>
    <script src="{{asset('plugin/highcharts-4.2.3/js/highcharts.js')}}"></script>
    <script src="{{asset('plugin/highcharts-4.2.3/js/modules/exporting.js')}}"></script>
    <script src="{{asset('plugin/fontawesome-free-5.10.1/js/all.min.js')}}"></script>
    <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>

    @yield('extra-js')
</body>

</html>
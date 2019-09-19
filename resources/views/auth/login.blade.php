<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title></title>

    <link rel="stylesheet" type="text/css" href="{{asset('css/page_signin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/simple-line-icons-webfont/simple-line-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/bootstrap-3.3.7/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/jquery-3.1.1/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/jquery-3.1.1/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugin/rvnm/jquery-rvnm.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/layout.css')}}">
</head>

<body>
    <div id="page_signin">
        <table>
            <tbody>
                <tr>
                    <td>
                        <div id="content">
                            <div id="logo">
                                <a href="{{url('/')}}">
                                    <img src="{{asset('img/dramania-light.png')}}" width="200px" height="52px">
                                </a>
                            </div>
                            <div id="form">
                                <div class="panel">
                                    <div class="panel-body">
                                        <form name="loginForm" class="loginForm" action="{{ route('login') }}"
                                            method="POST">
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="col-sm-12">

                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            USERNAME
                                                        </label>
                                                        <input id="email" type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email') }}" required
                                                            autocomplete="email" autofocus>

                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            PASSWORD
                                                        </label>
                                                        <input id="password" type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" required autocomplete="current-password">

                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="pull-right btn btn-hive">
                                                        Masuk
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="copy">
                                {{date('Y')}} &copy; DRAMANIA All RIGHTS RESERVED.
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
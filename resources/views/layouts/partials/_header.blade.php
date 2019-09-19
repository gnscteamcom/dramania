<div id="page_header">
    <div class="left">
        <a class="logo" href="{{url('/')}}">
            <img src="{{asset('img/dramania-light.png')}}" width="220px" height="57px">
        </a>
    </div>
    <div class="right">
        <div class="user">
            <div class="dropdown">
                <div class="dropdown-toggle" data-toggle="dropdown">
                    <div class="user-img user-img-32">
                        <div class="placeholder"></div>
                    </div>
                    <div class="user-info">
                        <div class="name">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="role">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="type">
                        
                        <div class="branch">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <div class="detail">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="name">Nama</td>
                                    <td class="separator">:</td>
                                    <td class="value">
                                        {{ Auth::user()->name }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="signout">
                        @php
                        $_signoutUrl = url('/logout');
                        @endphp
                        <a href="{{$_signoutUrl}}">
                            <i class="icon-logout"></i>
                            &nbsp;&nbsp;
                            Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
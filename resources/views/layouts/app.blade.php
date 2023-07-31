<x-laravel-ui-adminlte::adminlte-layout>

    <body class="hold-transition sidebar-mini layout-fixed" >

        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <div class="navbar-nav hidden">
                    <img src="{{ asset('images/loading-pacman.gif') }}" id="img_loading"
                        alt="test" width="50" height="50" style="display: none;margin:0;">
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                                class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                                <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                                    class="img-circle elevation-2" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')


            </div>


            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    {{-- <b>Version</b> 3.1.0 --}}
                </div>
                <strong>Copyright &copy; <a href="https://github.com/raden77" target="_blank">
                    Raden Papang Prayogo</a>.</strong>
                    All rights reserved.
            </footer>
        </div>

    </body>

    <script src="{{ asset('bootstrap-5.2.3-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        let token = $('meta[name="csrf-token"]').attr('content')

        function showloading(){
            $('#img_loading').css('display','inline-block')
            console.log('start loading');
            setTimeout(() => {
                console.log('stop loading');
                $('#img_loading').css('display','none')
            }, 1200);
        }

        function hideloading(){
            $('#img_loading').css('display','none')

        }

        // otomatis set csrf_token saat menggunakan ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });

        $(document).bind("ajaxSend", function(){
            showloading();
        }).bind("ajaxComplete", function(){
            hideloading();
        });

        $(document).ready(function() {
            $('.select2').select2({
                width: '50%'
            });
            $('.tabledata').DataTable();
        });
    </script>
     @yield('script')
</x-laravel-ui-adminlte::adminlte-layout>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{{ ( isset( $head_title ) ? $head_title : 'ویرا پلتفرم' ) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="theme-color" content="#283D92" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script type="text/javascript">
        let url_dashboard = "{{ url( '/dashboard' ) }}";
        let url           = "{{ url( '/' ) }}";
    </script>

    <link rel="stylesheet" type="text/css" href="{{ url('/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css?ver=' . env( "VERSION" ) ) }}" />

    @if( ( isset($discount_code) && $discount_code ) || ( isset($page_activation_code) && $page_activation_code ) )
        <link rel="stylesheet" type="text/css" href="{{ url( 'assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css?ver=' . env( "VERSION" ) ) }}" />
        <link rel="stylesheet" type="text/css" href="{{ url( 'assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css?ver=' . env( "VERSION" ) ) }}" />
        <link rel="stylesheet" type="text/css" href="{{ url( 'assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css?ver=' . env( "VERSION" ) ) }}" />
    @else
        <link rel="stylesheet" type="text/css" href="{{ url( '/assets/libs/admin-resources/rwd-table/rwd-table.min.css?ver=' . env( "VERSION" ) ) }}" />
        <script type="text/javascript" src="{{ url( '/assets/libs/jquery/jquery.min.js?ver=' . env( "VERSION" ) ) }}"></script>
    @endif

    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/css/bootstrap.min.css?ver=' . env( "VERSION" ) ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/css/icons.css?ver=' . env( "VERSION" ) ) }}" />

    <link rel="stylesheet" type="text/css" href="{{ url( 'assets/css/app.css?ver=' . env( "VERSION" ) ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/css/libs/jquery.md.bootstrap.datetimepicker.style.css?ver=' . env( "VERSION" ) )  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/libs/sweetalert2/sweetalert2.min.css?ver=' . env( "VERSION" ) ) }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/libs/select2/css/select2.min.css?ver=' . env( "VERSION" ) ) }}"/>

    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/ibv_vp_project.css?ver=' . env( "VERSION" ) ) }}" />
</head>

<body data-layout="detached" data-topbar="colored">
    <div id="ibv_vp_fix_loading" class="ibv_vp_fix-loading">
        <div class="mdi mdi-loading fa-spin"></div>
    </div>
    <div id="ibv_vp_fix_loading_2" class="ibv_vp_fix-loading">
        <div class="mdi mdi-loading fa-spin"></div>
    </div>
    <div class="container-fluid">
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div>
                            <!-- LOGO -->
                            <div class="navbar-brand-box">
                                <a href="{{ url('dashboard') }}" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="{{ url( '/inc/img/logo.png' ) }}" height="30"/>
                                    </span>
                                    <span class="logo-lg">
                                            <img src="{{ url( '/inc/img/logo.png' ) }}" height="50"/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="vertical-menu">

                <section class="h-100">
                    <div class="user-wid text-center py-4">
                        <div class="user-img">
                            <img src="{{ isset($user_data) ? $user_data->profile_image: url( DIR_PROFILE_IMAGE . "default.png" ) }}" alt="" class="avatar-md mx-auto rounded-circle">
                        </div>
                        <div class="mt-3">
                            <a href="#" class="text-dark font-weight-medium font-size-16 line-height-h">
                                {!! $user_data->firstname !!} {!! $user_data->lastname !!}
                            </a>
                        </div>
                    </div>
                    <section id="sidebar-menu">
                        @section( "submenu" )
                        @show
                    </section>
                </section>
            </div>
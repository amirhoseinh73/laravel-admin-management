    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/css/bootstrap.min.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/css/icons.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/fonts/fontawsome/css/all.min.css' ) }}" />

    <link rel="stylesheet" type="text/css" href="{{ url( 'assets/css/app.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/css/libs/jquery.md.bootstrap.datetimepicker.style.css' )  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/libs/sweetalert2/sweetalert2.min.css' ) }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url( '/assets/libs/select2/css/select2.min.css' ) }}"/>

    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/project.css?ver=' . env( "VERSION" ) ) }}" />
</head>

<body data-layout="detached" data-topbar="colored">
    <div id="fix_loading" class="fix-loading">
        <div class="mdi mdi-loading fa-spin"></div>
    </div>
    <div id="fix_loading_2" class="fix-loading">
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
                        @include( "templates.sidemenu" )
                    </section>
                </section>
            </div>

            <div class="main-content">

                <div class="page-content">
            
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="page-title mb-0 font-size-18">{{ $title }}</h4>
            
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">{{ $description }}</li>
                                    </ol>
                                </div>
            
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
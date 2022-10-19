<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{{ (isset($head_title) ? $head_title : 'ویرا پلتفرم') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="ViraCompany" name="author">
    <meta name="theme-color" content="#283D92">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ url('/assets/css/bootstrap.min.css?ver=' . env( "VERSION" ) ) }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/css/icons.css?ver=' . env( "VERSION" ) ) }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/css/app.css?ver=' . env( "VERSION" ) ) }}" id="app-style" rel="stylesheet" type="text/css" />


    <link href="{{ url('/inc/css/ibv_vp_project.css?ver=' . env( "VERSION" ) ) }}" id="app-style" rel="stylesheet" type="text/css" />
    <script src="{{ url('/assets/libs/jquery/jquery.min.js?ver=' . env( "VERSION" ) ) }}"></script>

    <script type="text/javascript">
        let ibv_vp__url_index     = "{{ url( '/' ) }}"
        let ibv_vp__url_ajax_log  = "{{ url( '/login-submit' ) }}"
        let ibv_vp__url_dashboard = "{{ url( '/dashboard' ) }}"
    </script>
</head>
<body>

<div id="ibv_vp_fix_loading" class="ibv_vp_fix-loading">
    <div class="mdi mdi-loading fa-spin"></div>
</div>
<div id="ibv_vp_fix_loading_2" class="ibv_vp_fix-loading">
    <div class="mdi mdi-loading fa-spin"></div>
</div>
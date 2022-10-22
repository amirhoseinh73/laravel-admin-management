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

    <link rel="stylesheet" type="text/css" href="{{ url('/assets/css/bootstrap.min.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/assets/css/icons.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/assets/css/app.css' ) }}" />


    <link rel="stylesheet" type="text/css" href="{{ url('/inc/css/project.css?ver=' . env( "VERSION" ) ) }}" />

    <script type="text/javascript">
        let url = "{{ url( '/' ) }}"
    </script>
</head>
<body>

<div id="fix_loading" class="fix-loading">
    <div class="mdi mdi-loading fa-spin"></div>
</div>
<div id="fix_loading_2" class="fix-loading">
    <div class="mdi mdi-loading fa-spin"></div>
</div>
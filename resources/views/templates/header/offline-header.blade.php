<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <title>{{ (isset($titlePage) ? $titlePage : 'ویرا پلتفرم') }}</title>

    <meta content="ViraCompany" name="author">
    <meta name="theme-color" content="#283D92">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/libs/normalize.min.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/libs/bootstrap.min.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/libs/alertify.rtl.css' ) }}" />

    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/fonts/fontawsome/css/all.min.css' ) }}" />

    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/global-book/config.css?ver=' . env( "VERSION" ) ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/global-book/font.css?ver=' . env( "VERSION" ) ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/global-book/project.css?ver=' . env( "VERSION" ) ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ url( '/inc/css/offline.css?ver=' . env( "VERSION" ) ) }}" />

    <script type="text/javascript">
        let url = "{{ url( '/' ) }}"
    </script>
</head>
<body>
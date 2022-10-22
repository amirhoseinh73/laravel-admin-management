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
        let url = "{{ url( '/' ) }}";
    </script>

    <link rel="stylesheet" type="text/css" href="{{ url('/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css' ) }}" />
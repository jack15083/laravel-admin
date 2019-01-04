<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel-Admin</title>
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body style="margin: 0;padding: 0" >
<div id="app"></div>

<script src="{{mix('/build/manifest.js')}}"></script>
<script src="{{mix('/build/vendor.js')}}"></script>
<script src="{{mix('/build/app.js') }}"></script>

</body>
</html>

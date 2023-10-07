<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
    @yield('contenu')
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
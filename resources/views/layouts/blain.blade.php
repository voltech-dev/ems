<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EMS') }}</title>

    <!-- Scripts -->
   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Jolly+Lodger' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">

    <style type = "text/css">
    p { font-family: 'Jolly Lodger', cursive; }
</style>
</head>

<body>
    <div >       

        <div class="container ">            
                <div class="col pt-4">
                    @yield('content')
                </div>            
        </div>
    </div>
</body>

</html>
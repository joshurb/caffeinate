<html>
<head>
    <title>App Name - @yield('title')</title>


    @stack('css')


</head>

<body>
@section('sidebar')
    This is the master sidebar.
@show

    <div class="container">
        @yield('content')
    </div>

    <script
            src="https://code.jquery.com/jquery-3.4.0.min.js"
            integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
            crossorigin="anonymous"></script>
    <!-- Load React. -->
    <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
    <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>


@stack('scripts')
</body>
</html>
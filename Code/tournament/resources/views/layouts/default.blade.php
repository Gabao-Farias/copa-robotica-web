<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ trim(View::yieldContent('page-title')) }} - {{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-theme.css') }}" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="{{ asset('js/socket.io.js') }}"></script>
</head>
<body>
    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/noty/js/noty/packaged/jquery.noty.packaged.min.js') }}"></script>
    <script src="{{ asset('js/noty/js/noty/themes/relax.js') }}"></script>
    @include('public-configs')
    <script src="{{ asset('js/Notify.js') }}"></script>
    <script src="{{ asset('js/Alerter.js') }}"></script>
    <script src="{{ asset('js/Responses.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

            $('.table-responsive').on('show.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "visible");
            });

            $('.table-responsive').on('hide.bs.dropdown', function () {
                $('.table-responsive').css("overflow", "auto");
            });
        });
    </script>
    @yield('assets')
</body>
</html>
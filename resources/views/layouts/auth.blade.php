<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>tower</title>

    <!-- Bootstrap core CSS -->
    <link href="/admin_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin_assets/css/flatpickr.min.css" rel="stylesheet">
    <link href="/admin_assets/css/style.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="position-relative min-vh-100 d-flex flex-column bg-body-secondary">
    <header class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
        <nav class="container-xxl flex-nowrap">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if(route('tower::innate::login') && !request()->route()->named('tower::innate::login'))
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link" href="{{ route('tower::innate::login') }}">Войти</a>
                        </li>
                    @endif
                    @if (Route::has('tower::innate::register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tower::innate::register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                @endguest
            </ul>
        </nav>
    </header>
    <main class="flex-fill d-flex flex-column justify-content-center">
        @yield('content')
    </main>
    <div class="align-self-center mb-2">
        <small class="text-muted">powered by tower admin v2.0.0</small>
    </div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="/admin_assets/js/bootstrap.bundle.min.js"></script>
<script src="/admin_assets/libs/tinymce/tinymce.min.js"></script>
<script src="/admin_assets/js/slug.js"></script>
<script src="/admin_assets/js/flatpickr.js"></script>
<script src="/admin_assets/js/flatpickr_ru.js"></script>
<script>

    tinymce.init({
        selector: '.mce', plugins: ['lists','link','code','table'],
        toolbar: 'numlist bullist link code',
        forced_root_block : "",
        height : "480"
    });
</script>
<script>
    $(document).ready(
        function(){
            $(('[data-slug-from]')).each(function(){
                var $original = $(this);
                var id = $(this).data('slug-from');
                $(document).on('keyup', '#' + id, function () {
                    $original.val(url_slug($(this).val()));
                });
            });

            $('.date').flatpickr({
                "locale": "ru",
                "dateFormat": "d.m.Y"
            });
        }
    );
</script>
</body>
</html>

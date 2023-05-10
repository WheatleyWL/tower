<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>tower</title>

    <!-- Bootstrap core CSS -->
    <link href="/admin_assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="/admin_assets/css/flatpickr.min.css" rel="stylesheet">
    <link href="/admin_assets/css/style.css" rel="stylesheet">
    <link href="/admin_assets/libs/select2/select2.min.css" rel="stylesheet">
    <script defer src="/admin_assets/js/jquery-3.6.4.min.js"></script>
    <script defer src="/admin_assets/libs/select2/select2.full.min.js"></script>
    <script defer src="/admin_assets/libs/select2/ru.js"></script>

    <script defer src="/admin_assets/js/tower.js"></script>
    <script defer src="/admin_assets/js/components/theme.js"></script>
    <script defer src="/admin_assets/js/components/dropzone.js"></script>

    <!-- Dropzone -->
    <script defer src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />

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
    <!-- Custom styles for this template -->
    <link href="/admin_assets/css/dashboard.css" rel="stylesheet">
    <link href="/admin_assets/libs/fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
<header class="navbar navbar-expand navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <button class="btn p-2 m-0 d-md-none collapsed"
            style="background-color: rgba(0, 0, 0, .25)"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#tower-sidebar-collapse"
            aria-controls="tower-sidebar-collapse"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">tower</a>
    <div class="d-flex flex-grow-1"></div>
    <ul class="navbar-nav me-auto">
        <li class="nav-item text-nowrap">
            <form id="logout-form" action="{{ route('tower_admin::logout') }}" method="POST">
                <button type="submit" class="btn btn-outline-light">Выход</button>
                @csrf
            </form>
        </li>
        <li class="nav-item ms-1 me-1">
            <button class="btn btn-outline-secondary" type="button" id="tower_theme_switcher">
                <i class="bi bi-moon-stars-fill" id="tower_theme_switcher_icon"></i>
            </button>
        </li>
    </ul>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="tower-sidebar-collapse" class="col-md-3 col-lg-2 d-md-block bg-body-secondary sidebar collapse">
            <div class="sidebar-sticky">
                {!! $menu !!}
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-3">
            @if (session('message'))
                <div class="alert {{session('message')['class']}}">
                    {{ session('message')['text'] }}
                </div>
            @endif
            {!! $content !!}
        </main>
    </div>

</div>

@foreach(\zedsh\tower\Facades\TowerAdmin::getNamedTemplates() as $slotName => $view)
    <template id="{{ $slotName  }}">
        {{ view($view) }}
    </template>
@endforeach

<script defer src="/admin_assets/js/bootstrap.bundle.min.js"></script>
<script defer src="/admin_assets/libs/tinymce/tinymce.min.js"></script>
<script defer src="/admin_assets/js/slug.js"></script>
<script defer src="/admin_assets/js/flatpickr.js"></script>
<script defer src="/admin_assets/js/flatpickr_ru.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '.mce', plugins: ['lists','link','code','table'],
            toolbar: 'numlist bullist link code',
            forced_root_block : "",
            height : "250"
        });

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

        $('.select2').select2();
    });
</script>
</body>
</html>

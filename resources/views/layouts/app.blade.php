<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title --> 
    <link rel="icon" href="{{ asset('images/ontime.png') }}" type="image/x-icon">
    <title>{{ config('app.name') }} @yield('title')</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    
    <!-- CSS -->
    @yield('styles')
    @stack('styles')
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.0.2') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('css/myStyle.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
</head>
<body class="g-sidenav-show" style=" background-image: url('https://app.midtrans.com/payment-links/assets/bg.jpg');">
    <div class="min-height-400 position-absolute w-100" style="background: #4C92FA"></div>
    <!-- Navigation -->
    @include('layouts.sidebar')
    <main class="main-content position-relative border-radius-lg">
        <div class="alert alert-warning text-center position-absolute fw-bold fs-12 p-2" style="z-index: 9999999; left: 42%; margin-top: 20px; display: none" id="loading">Harap Tunggu</div>
        <!-- Header -->
        @include('layouts.header')
        <!-- Content -->
        @yield('content')
    </main>
</body>
    <!-- JS -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.2') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/myScript.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/').'/') !!};
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        Fancybox.bind("[data-fancybox]", {
        // Your custom options
        });
    </script>
    @yield('scripts')
    @stack('scripts')
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
</html>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Motonos">
    <meta name="keywords" content="Motonos">
    <meta name="author" content="Motonos">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Motonos</title>
    <link rel="apple-touch-icon" href="{{ URL::to($setting['favicon'] ?? '') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to($setting['favicon'] ?? '') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/admin/app-assets/vendors/css/vendors.min.css') }}">

    <!--summernote -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/admin/app-assets/vendors/css/editors/summernote.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/admin/app-assets/vendors/css/editors/codemirror.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/admin/app-assets/vendors/css/editors/theme/monokai.css') }}">
    <!--summernote -->

    <!--Datatable -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/admin/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <!--Datatable -->

    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/admin/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/admin/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/admin/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/admin/app-assets/css/components.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/admin/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/modules/admin/app-assets/css/core/colors/palette-gradient.css') }}">

    <!-- Sweetalert -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/modules/admin/app-assets/css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    @yield('css_lib')
    @yield('css_custom')
    <style>
        /* Prevent double scroll — only one scroll layer */
        html,
        body {
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .app-content.content {
            overflow: visible !important;
        }

        .content-wrapper {
            overflow: visible !important;
            height: auto !important;
        }

        .content-body {
            overflow: visible !important;
        }

        /* Make sidebar content fill available height without forced scroll */
        .main-menu-content {
            height: auto !important;
            max-height: calc(110vh - 130px) !important;
            /* 60px navbar + 60px footer */
            overflow-y: auto !important;
            padding-bottom: 20px !important;
            /* breathing room at bottom */
        }

        .main-menu {
            padding-bottom: 0 !important;
        }

        /* Thin subtle scrollbar */
        .main-menu-content::-webkit-scrollbar {
            width: 4px;
        }

        .main-menu-content::-webkit-scrollbar-thumb {
            background-color: #C0C0C0;
            border-radius: 4px;
        }

        .main-menu-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: absolute;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(/assets/images/loading.gif) center no-repeat;
        }

        .content-wrapper {
            opacity: 0.5;
        }

        .bg-info {
            background-color: #ffffff !important;
        }

        .main-menu.menu-light .navigation>li.active>a {
            font-weight: 700;
            background: none;
            margin: 0 1rem 0 1rem;
            border-radius: 0.3rem;
            color: #ff6600;
        }

        .main-menu.menu-light .navigation>li>a {
            padding: 12px 30px 12px 18px;
            padding-top: 1px;
            padding-bottom: 1px;
            padding-left: 47px;
        }

        .main-menu.menu-light .navigation .navigation-header span {
            font-weight: 500;
            text-transform: capitalize;
        }

        .main-menu.menu-light .navigation>li ul li>a {
            padding: 12px 18px 12px 54px;
            padding-top: 1px;
            padding-bottom: 1px;
            padding-left: 20px;
        }

        .main-menu.menu-light .navigation>li.open>ul>li:hover>a {
            padding: 12px 18px 12px 54px;
            padding-top: 1px;
            padding-bottom: 1px;
            padding-left: 20px;
        }

        body.vertical-layout.vertical-menu.menu-expanded .main-menu {
            border-right: 3px solid #C0C0C0;
        }

        .breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: ">";
        }

        .main-menu.menu-light .navigation>li .active>a {
            font-weight: 700;
            background: none;
            margin: 0 0rem 0 0rem;
            border-radius: 0.3rem;
            color: #ff6600 !important;
            padding-left: 20px;
            font-weight: 700;
            font-size: 15px;
        }

        .badge-success {
            background-color: green;
        }

        #headingCollapse14:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e843";
            transition: all 300ms linear 0s;
        }

        #headingCollapse1:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
        }

        #headingCollapse2:before {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e842";
            transition: all 300ms linear 0s;
        }

        .collapse-icon [data-toggle="collapse"]:after {
            position: absolute;
            top: 48%;
            right: 20px;
            margin-top: -8px;
            font-family: 'feather';
            content: "\e845";
            transition: all 300ms linear 0s;
        }

        .collapsed {
            border-bottom-left-radius: 0px !important;
            border-bottom-right-radius: 0px !important;
        }

        .main-menu.menu-light .navigation>li.sub_active>a {
            font-weight: 700;
            background: none;
            margin: 0 1rem 0 1rem;
            border-radius: 0.3rem;
            color: #ff6600;
            padding-bottom: 1px;
            padding-top: 2px;
            padding-left: 32px;
        }

        .collapse-icon [aria-expanded="true"]:before {
            opacity: 1;
        }

        .footers {
            bottom: 0;
            left: 0;
            border-top: 2px solid black;
            padding-top: 10px !important;
            width: 100%;
        }

        .btn-success:focus,
        .btn-success:active {
            border-color: #ff6600 !important;
            background-color: #ff6600 !important;
            color: #FFF !important;
        }

        .badge-primary-1 {
            background-color: #ff6600;
        }

        .text-secondary {
            color: black !important;
        }

        h6 {
            color: black !important;
        }

        h4 {
            color: black !important;
        }

        .main-menu.menu-light .navigation>li.hover>a {
            padding-left: 47px;
        }

        .sidebar-overview {
            border-radius: 7px;
            border: 2px solid black;
            background-color: white;
            padding-bottom: 20px;
            box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
        }

        .theme-label {
            color: black !important;
            font-size: 0.95rem;
            font-weight: 600 !important;
            margin: 0;
            padding-right: 15px;
        }
    </style>
    <style>
        /* --- Global Variables --- */
        :root {
            --border-color-dark: #000000;
            --border-color-light: #e0e0e0;
            --text-muted: #6b7280;
            --padding-header: 16px 24px;
            --padding-body: 24px;
            --padding-row: 16px 0;
        }

        /* --- Container / Card Styles --- */
        .page-card {
            background-color: #ffffff;
            border: 1px solid var(--border-color-dark);
            margin-bottom: 24px;
            /* Space between stacked cards */
        }

        .page-card-header {
            padding: var(--padding-header);
            border-bottom: 1px solid var(--border-color-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: bold;
        }

        .page-card-body {
            padding: var(--padding-body);
        }

        /* --- Data List / Alignment Styles --- */
        .data-row {
            display: grid;
            grid-template-columns: 35% 65%;
            /* Aligns labels and values perfectly */
            padding: var(--padding-row);
            border-bottom: 1px solid var(--border-color-light);
            align-items: center;
        }

        .data-row:last-child {
            border-bottom: none;
            /* Removes line from the last item */
        }

        .data-label {
            color: var(--text-muted);
            font-size: 14px;
        }

        .data-value {
            color: #000000;
            font-size: 14px;
        }

        /* --- Global Action Buttons (View, Edit, Add) --- */
        .btn-action {
            background-color: #000000;
            color: #ffffff;
            padding: 8px 24px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action:hover {
            background-color: #333333;
        }

        /* Container to align buttons to the right, just like the image */
        .action-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu"
    data-col="2-columns">

    @include('vender::layouts.header')
    @if (!request()->routeIs('vender.agreements'))
   
    @include('vender::layouts.sidebar')
@endif

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper"
            style="padding-left:0px; padding-top: 2px; background: white; min-height: 84vh; overflow: visible;">
            @yield('header')
            <div class="content-body" style="padding-left: 2rem;padding-top: 2rem">
                @yield('content')
                <div class="se-pre-con"></div>
            </div>
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
 @if (!request()->routeIs('vender.agreements'))
    @include('vender::layouts.footer')
    @endif

    <script src="{{ asset('/modules/admin/app-assets/vendors/js/vendors.min.js') }}"></script>

    <!-- BEGIN: Page Vendor JS -->
    <script src="{{ asset('/modules/admin/app-assets/vendors/js/editors/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('/modules/admin/app-assets/vendors/js/editors/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('/modules/admin/app-assets/vendors/js/editors/summernote/summernote.js') }}"></script>
    <!-- END: Page Vendor JS -->

    {{-- Core framework JS - order matters: app-menu before app --}}
    <script src="{{ asset('/modules/admin/app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('/modules/admin/app-assets/js/core/app.min.js') }}"></script>

    <!--Datatable -->
    <script src="{{ asset('/modules/admin/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('/modules/admin/app-assets/js/scripts/tables/datatables/datatable-basic.js') }}"></script>
    <!--Datatable -->

    <!-- Sweetalert -->
    <script src="{{ asset('/modules/admin/app-assets/js/sweetalert.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @yield('scripts_lib')
    @yield('script')

    <!-- Bootstrap Validation -->
    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".se-pre-con").fadeOut("slow");
            $('.content-wrapper').css("opacity", 1);
        });
    </script>

    <!-- Fix i18next absolute path so it works on all routes -->
    <script>
        $(window).on('load', function() {
            i18next.init({
                debug: false,
                fallbackLng: 'en',
                backend: {
                    loadPath: '/modules/admin/app-assets/data/locales/@{{ lng }}.json'
                },
                returnObjects: true
            }, function(err, t) {
                jqueryI18next.init(i18next, $);
            });
        });
    </script>

    <!-- Auto-open sidebar on page load for tablet/desktop screens -->
    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                if ($(window).width() >= 768) {
                    $('body').removeClass('menu-hide menu-collapsed').addClass('menu-expanded');
                    $.app.menu.expanded = true;
                    $.app.menu.collapsed = false;
                    $.app.menu.hidden = false;

                    // ✅ Let sidebar content grow naturally with viewport
                    $('.main-menu-content').css('height', 'auto');
                }
            }, 300);
        });

        // Recalculate on window resize
        $(window).on('resize', function() {
            if ($(window).width() >= 768) {
                $('.main-menu-content').css('height', 'auto');
            }
        });
    </script>


    <!-- Toastr notifications -->
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}", {
                timeOut: 500000000,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                positionClass: "toast-top-right",
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            });
        @elseif (session('error'))
            toastr.error("{{ session('error') }}", {
                timeOut: 500000000,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                positionClass: "toast-top-right",
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            });
        @endif
    </script>

</body>

</html>

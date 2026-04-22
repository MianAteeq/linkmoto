<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

@include('frontend::new-layouts.head')


<body class="vertical-layout vertical-menu 2-columns fixed-navbar menu-expanded" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    @include('frontend::new-layouts.navbar')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    @include('frontend::new-layouts.sidebar')

    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            @yield('content')
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    @include('frontend::new-layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Bootstarp Validion -->

    <script>
        @if (session('message'))
            //  alert(1);
            toastr.success("{{ session('message') }}", {
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.nav-item.has-sub').forEach(function(el) {
                if (el.querySelector('a').textContent.trim() === 'Agreements') {
                    el.classList.remove('has-sub');
                }
            });
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            // A tiny timeout ensures the theme's core JS has fully finished its screen calculations
            setTimeout(function() {
                // Check if the screen is at the 768px breakpoint (or larger, up to 992px typically for tablets)
                if (window.innerWidth >= 768) {
                    let bodyTag = document.body;

                    // If the theme wrongly collapsed it, fix it
                    if (bodyTag.classList.contains('menu-collapsed')) {
                        bodyTag.classList.remove('menu-collapsed');
                        bodyTag.classList.add('menu-expanded');
                    }

                    // Ensure the menu is actually visible
                    let menu = document.getElementById('main-menu-navigation');
                    if (menu) {
                        menu.style.display = 'block';
                    }
                }
            }, 150); // 150ms delay is imperceptible to the user but guarantees we override the theme JS
        });
    </script>
</body>
<!-- END: Body-->

</html>

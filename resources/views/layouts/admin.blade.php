<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('partials/head')
<body>
<!-- Sidebar -->
@include('partials/sidebar')
<!-- /Sidebar -->

<!-- Main -->
<div class="main">
    <!-- Main header -->
    @include('partials/main-header')
    <!-- /Main header -->

    <!-- Main body -->
    <div class="main-body">
        @yield('breadcrumb')
        @include('notifications/flash-message')

        @yield('content')
    </div>
    <!-- /Main body -->
</div>
<!-- /Main -->

<!-- Search Modal -->
@yield('modal')
<!-- /Search Modal -->

<!-- Backdrop for expanded sidebar -->
<div class="sidebar-backdrop" id="sidebarBackdrop" data-toggle="sidebar"></div>
<!-- Plugins -->
@yield('jquery')
</body>
</html>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin | Help Together Group</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    @include('layouts.backend.partials.style')


    @yield('style')
</head>

<body data-sidebar="dark" data-layout-mode="light">

    <!-- [ Start: Layout Wrapper ] -->
    <div id="layout-wrapper">
        @include('layouts.backend.partials.header')

        @include('layouts.backend.partials.sidenav')

        <!--[ Main Content ] start -->
        <div class="main-content">
            @yield('content')
            @include('layouts.backend.partials.footer')
        </div>

    </div>
    @php
        $statusMessage = '';
        if (session()->get('success')) {
            $statusMessage = session()->get('success');
        } elseif (session()->get('error')) {
            $statusMessage = session()->get('error');
        } elseif (session()->get('failure')) {
            $statusMessage = session()->get('failure');
        }
    @endphp


    @include('layouts.backend.partials.script')

    @yield('script')
</body>

</html>

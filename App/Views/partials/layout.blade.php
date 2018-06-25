<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('partials.styles')
</head>

<body>
    @if(isset($flash))
        @include('components.flash')
    @endif

    @include('partials.navigation')
    <div id="content">
        @include('includes.errors')
        @yield('content')
    </div>

    @include('partials.scripts')

</body>

</html>
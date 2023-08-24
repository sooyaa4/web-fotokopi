<!doctype html>
<html lang="en">

<head>
    @include('template.include.head')
</head>

<body>
    <div class="container py-3">
        <header>
            @include('template.layouts.header')
        </header>

        <main class="flex-shrink-0">
            @include('template.layouts.alert')
            @yield('content')

        </main>

        <footer class="pt-4 my-md-5 pt-md-5 border-top sticky-bottom">
            @include('template.layouts.footer')
        </footer>
    </div>
    @include('template.include.script')
</body>

</html>

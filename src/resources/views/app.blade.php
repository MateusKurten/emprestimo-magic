<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Monografia - Mateus</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Flowbite CDN (biblioteca com componentes tailwind, ex:modal) -->
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.3.3/dist/flowbite.min.css" />

        <!-- Alpine -->
        <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
        <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div id="app">
            <div class="flex flex-row">
                @include('includes.sidenav')
                <div class="w-full md:flex-1 relative">
                    <main>
                        <div class="px-8 py-6">
                            @if(session('msg'))
                                @widget('Alert', session('msg'))
                            @endif

                            @if(isset($msg))
                                @widget('Alert', $msg)
                            @endif

                            @yield('content')
                        </div>
                    </main>
                </div>
            </div>
        </div>
        <script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>
    </body>
</html>

@if (file_exists(public_path('build/manifest.json')))
    @if (isset($includeReact) && $includeReact)
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @else
        @vite('resources/css/app.css')
    @endif
@else
    <link rel="stylesheet" href="{{ asset('assets/site.css') }}">
@endif


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} class="h-full bg-gray-900"">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body class="h-full">
        {{ $slot }}
    </body>
</html>

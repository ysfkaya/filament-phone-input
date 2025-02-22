<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script
        src="https://cdn.jsdelivr.net/npm/async-alpine@2.x.x/dist/async-alpine.script.js"
        defer
    ></script>
    <script
        src="https://unpkg.com/alpine-lazy-load-assets@latest/dist/alpine-lazy-load-assets.cdn.js"
        defer
    ></script>
</head>
<body>
    {{ $slot }}

    @stack('scripts')
</body>
</html>

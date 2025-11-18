<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'App') }}</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f7f7f8;color:#111}
        .container{max-width:720px;margin:4rem auto;padding:2rem;background:#fff;border:1px solid #e6e6e6;border-radius:6px}
    </style>
</head>
<body>
    <div class="container">
        @if(isset($description))
            <p class="small">{{ $description }}</p>
        @endif

        {{ $slot }}
    </div>
</body>
</html>

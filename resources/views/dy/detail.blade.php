<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZIJOL_API</title>
    <!-- Fonts -->
    <link href="/css/app.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    @isset($user)
        <div class="card">
            <div class="card-header">
                {{ $user->raw_data['nickname'] }}
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $user->raw_data['nickname'] }}</h5>
                <code class="card-text">{{ json_encode($user->raw_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</code>
            </div>
        </div>
    @endisset
</div>
</body>
</html>

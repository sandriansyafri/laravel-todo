<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | Log in</title>

    @include('layouts.auth.style')
</head>

<body class="hold-transition login-page">
    @yield('content')
    @include('layouts.auth.script')
</body>

</html>
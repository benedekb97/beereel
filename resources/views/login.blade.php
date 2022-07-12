<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Jelentkezz be</title>
    </head>
    <body>
        <form action="{{ route('authenticate') }}" method="POST">
            {{ csrf_field() }}
            <input type="text" name="username">
            <input type="password" name="password">
            <button type="submit">Login</button>
        </form>
    </body>
</html>

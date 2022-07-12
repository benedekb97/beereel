<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Regisztrálj</title>
    </head>
    <body>
        Regisztrálás lol
        <form action="{{ route('registration') }}" method="POST">
            {{ csrf_field() }}
            <input type="text" placeholder="Felhasználónév" name="username"/>
            <input type="password" placeholder="Jelszó" name="password_first"/>
            <input type="password" placeholder="Jelszó megerősítés" name="password_second"/>
            <button type="submit">Regisztrálok!</button>
        </form>
    </body>
</html>

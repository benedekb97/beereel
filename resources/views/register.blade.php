@extends('layouts.main')

@section('title', 'Regisztráció')

@section('content')
    <div class="col-lg-6 offset-lg-3 mt-3">
        <h1>Üdv a <b>BeerEel</b> gebin weboldalán!</h1>
        <p>A tartalom eléréséhez regisztrálj ;)</p>
        <form action="{{ route('registration') }}" method="POST">
            @isset($kagi)
                @if ($kagi === 'password')
                    <div class="alert alert-danger">
                        Egyezzen meg a két jelszó, legyen minimum 8 karakter
                    </div>
                @endif
                @if ($kagi === 'username')
                    <div class="alert alert-danger">
                        Ez a felhasználónév már foglalt :(
                    </div>
                @endif
            @endisset
            <div class="mb-3 input-group">
                <input required type="text" name="username" id="username" placeholder="Felhasználónév"
                       class="form-control form-control-lg"/>
            </div>
            {{ csrf_field() }}
            <div class="input-group mb-3">
                <input required type="password" name="password" id="password" placeholder="Jelszó"
                       class="form-control-lg form-control"/>
            </div>
            <div class="input-group mb-3">
                <input required type="password" name="password2" id="password2" placeholder="Mégegyszer"
                       class="form-control-lg form-control"/>
            </div>
            <div class="input-group d-grid">
                <button class="btn d-block btn-lg btn-primary" type="submit">Regisztrálok</button>
            </div>
        </form>
    </div>
@endsection

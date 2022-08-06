@extends('layouts.main')

@section('title', 'Regisztráció')

@section('content')
    <div class="col-lg-6 offset-lg-3 mt-3">

        <form action="{{ route('registration') }}" method="POST">
            <div class="mb-3 input-group">
                <input type="text" name="username" id="username" placeholder="Felhasználónév"
                       class="form-control form-control-lg"/>
            </div>
            {{ csrf_field() }}
            <div class="input-group mb-3">
                <input type="password" name="password" id="password" placeholder="Jelszó"
                       class="form-control-lg form-control"/>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password2" id="password2" placeholder="Mégegyszer"
                       class="form-control-lg form-control"/>
            </div>
            <div class="input-group d-grid">
                <button class="btn d-block btn-lg btn-primary" type="submit">Regisztrálok</button>
            </div>
        </form>
    </div>
@endsection

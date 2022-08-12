@extends('layouts.home')

@section('title', 'Keklol')

@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#b6effb" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
    </svg>
    <div class="col-lg-6 mt-3 offset-lg-3">
        <div class="alert alert-info">
            <span class="text-dark"><svg class="bi flex-shrink-0 me-2" style="stroke:black; fill:black;" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg> Amit ide feltöltesz az láthatóvá válik egy napig mindazoknak akik szintén töltöttek fel képet.</span><br>
            Utána eltűnik mindörökké ✨
        </div>

    </div>
    <div class="row-cols-1">
        <div class="col-lg-6 mt-3 offset-lg-3">
            <div class="card shadow-sm bg-dark">
                <div class="card-body">
                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="front" class="form-label">Előlapi kép</label>
                            <input type="file" name="front" class="form-control bg-dark text-white" id="front">
                        </div>
                        <div class="mb-3">
                            <label for="back" class="form-label">Hátlapi kép</label>
                            <input type="file" name="back" class="form-control bg-dark text-white" id="back">
                        </div>
                        <div class="input-group d-grid">
                            <button class="btn d-block btn-primary" type="submit">Mentés</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

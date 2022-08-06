@extends('layouts.home')

@section('title', 'Keklol')

@section('content')
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

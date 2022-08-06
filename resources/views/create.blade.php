@extends('layouts.home')

@section('title', 'Keklol')

@section('content')
    <div class="row-cols-1">
        <div class="col-lg-4 mt-3 offset-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name="front">
                        <input type="file" name="back">
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

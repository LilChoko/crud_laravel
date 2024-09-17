@extends('layouts.base')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Iniciar Sesión</h2>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
</div>
@endsection

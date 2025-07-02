@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input id="password" type="password" class="form-control" name="password" required>
        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmez le mot de passe</label>
        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
    <p class="mt-3 text-center"><a href="{{ route('login') }}">Déjà inscrit ?</a></p>
</form>
@endsection

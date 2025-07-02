@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input id="password" type="password" class="form-control" name="password" required>
        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">Se souvenir de moi</label>
    </div>
    <div class="mb-3 text-end">
        <span class="small">Mot de passe perdu ? Contactez <a href="mailto:{{ config('mail.owner_address') }}">l'administrateur</a>.</span>
    </div>
    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
</form>
@endsection

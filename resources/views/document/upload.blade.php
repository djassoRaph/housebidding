@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-4">Justificatif de solvabilité</h1>

    @if(session('status') === 'document-submitted')
        <div class="alert alert-success">Document envoyé. Il sera vérifié prochainement.</div>
    @endif

    @if($user->justificatif_path)
        <p>Document actuel : <a href="{{ asset('storage/'.$user->justificatif_path) }}" target="_blank">voir le fichier</a></p>
        <p class="{{ $user->document_valide ? 'text-success' : 'text-warning' }}">
            {{ $user->document_valide ? 'Validé' : 'En attente de validation' }}
        </p>
    @endif

    <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="justificatif" class="form-label">Choisir un fichier (PDF ou image)</label>
            <input type="file" name="justificatif" id="justificatif" class="form-control" required>
            @error('justificatif')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
@endsection

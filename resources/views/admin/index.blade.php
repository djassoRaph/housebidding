@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-4">Administration</h1>

    <h2 class="h5 mt-4">Utilisateurs</h2>
    <ul class="ps-3">
        @foreach($users as $user)
            <li>
                {{ $user->name }} - {{ $user->email }}
                @if($user->justificatif_path)
                    <a href="{{ asset('storage/'.$user->justificatif_path) }}" target="_blank">Justificatif</a>
                    @if(!$user->document_valide)
                        <form action="{{ route('admin.validate', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">Valider</button>
                        </form>
                    @else
                        <span class="badge bg-success">Validé</span>
                    @endif
                @endif
            </li>
        @endforeach
    </ul>

    <h2 class="h5 mt-4">Enchères</h2>
    <ul class="ps-3">
        @foreach($bids as $bid)
            <li>{{ $bid->user->name }} - {{ number_format($bid->amount,0,',',' ') }} € - {{ $bid->created_at->format('d/m/Y H:i') }}</li>
        @endforeach
    </ul>

    <h2 class="h5 mt-4">Vente</h2>
    <p>Status : {{ $property->closed ? 'Terminée' : 'En cours' }}</p>
    @if(!$property->closed)
    <form action="{{ route('admin.close') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger mt-2">Clore la vente</button>
    </form>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Administration</h1>

    <h2 class="text-xl font-bold mt-4">Utilisateurs</h2>
    <ul class="list-disc pl-5">
        @foreach($users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>

    <h2 class="text-xl font-bold mt-4">Offres</h2>
    <ul class="list-disc pl-5">
        @foreach($bids as $bid)
            <li>{{ $bid->user->name }} - {{ number_format($bid->amount,0,',',' ') }} € - {{ $bid->created_at->format('d/m/Y H:i') }}</li>
        @endforeach
    </ul>

    <h2 class="text-xl font-bold mt-4">Vente</h2>
    <p>Status : {{ $property->closed ? 'Terminée' : 'En cours' }}</p>
    @if(!$property->closed)
    <form action="{{ route('admin.close') }}" method="POST">
        @csrf
        <button type="submit" class="mt-2 px-4 py-2 bg-red-600 text-white">Clore la vente</button>
    </form>
    @endif
</div>
@endsection

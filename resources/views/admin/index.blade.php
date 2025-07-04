@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Administration</h1>

    @php use Illuminate\Support\Facades\Storage; @endphp

    <h2 class="text-xl font-bold mt-4">Utilisateurs</h2>
    <table class="min-w-full text-left border-collapse">
        <thead>
            <tr>
                <th class="border-b p-2">Nom / Email</th>
                <th class="border-b p-2">Téléphone</th>
                <th class="border-b p-2">Justificatif</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="border-b p-2">{{ $user->name ?? $user->email }}</td>
                    <td class="border-b p-2">{{ $user->phone_number }}</td>
                    <td class="border-b p-2">
                        @if($user->proof_path)
                            <a href="{{ Storage::url($user->proof_path) }}" class="text-indigo-600 underline">Télécharger</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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

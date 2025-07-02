@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-4">{{ $property->title }}</h1>
    <p class="mb-2">{{ $property->description }}</p>
    <p class="mb-2"><strong>Lieu :</strong> {{ $property->location }}</p>
    <p class="mb-2"><strong>Fin des enchères :</strong> {{ $property->end_at->format('d/m/Y H:i') }}</p>
    <p class="mb-4"><strong>Enchère actuelle :</strong> {{ $highestBid ? number_format($highestBid->amount,0,',',' ') . ' €' : 'Aucune' }}</p>

    @auth
        @if(!Auth::user()->document_valide)
            <p class="alert alert-warning">Vous devez fournir un justificatif de solvabilité pour participer à l’enchère.</p>
            <a href="{{ route('document.form') }}" class="btn btn-primary">Envoyer un justificatif</a>
        @elseif(!$property->closed && $property->end_at->isFuture())
        <form action="{{ route('bid.store') }}" method="POST" class="mb-4 mt-3">
            @csrf
            <label for="amount" class="form-label">Montant de l'enchère (min {{ number_format(($highestBid?->amount ?? $property->starting_price - $property->min_increment) + $property->min_increment,0,',',' ') }} €)</label>
            <input type="number" name="amount" id="amount" required class="form-control d-inline w-auto" />
            <button type="submit" class="btn btn-success ms-2">Enchérir</button>
        </form>
        @else
            <p class="text-danger fw-bold">La vente est terminée.</p>
        @endif
    @else
        <p><a href="{{ route('login') }}" class="text-decoration-underline">Connectez-vous</a> pour enchérir.</p>
    @endauth

    <h2 class="h5 mt-4 mb-2">Historique des enchères</h2>
    <div id="bids">
        @foreach($property->bids()->with('user')->orderByDesc('created_at')->get() as $bid)
            <p>{{ $bid->user->name }} - {{ number_format($bid->amount,0,',',' ') }} € - {{ $bid->created_at->format('d/m/Y H:i') }}</p>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
setInterval(() => {
    fetch('{{ route('property.bids') }}')
        .then(r => r.json())
        .then(bids => {
            let container = document.getElementById('bids');
            container.innerHTML = '';
            bids.forEach(bid => {
                const p = document.createElement('p');
                p.textContent = `${bid.user.name} - ${new Intl.NumberFormat('fr-FR').format(bid.amount)} € - ${new Date(bid.created_at).toLocaleString('fr-FR')}`;
                container.appendChild(p);
            });
        });
}, 5000);
</script>
@endpush

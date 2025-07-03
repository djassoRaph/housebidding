@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $property->title }}</h1>
    <p class="mb-2">{{ $property->description }}</p>
    <p class="mb-2"><strong>Lieu :</strong> {{ $property->location }}</p>
    <p class="mb-2"><strong>Fin des enchères :</strong> {{ $property->end_at->format('d/m/Y H:i') }}</p>
    <p class="mb-4"><strong>Enchère actuelle :</strong> {{ $highestBid ? number_format($highestBid->amount,0,',',' ') . ' €' : 'Aucune' }}</p>

    @php
        use Illuminate\Support\Facades\File;
        $galleryImages = File::exists(public_path('photos'))
            ? collect(File::files(public_path('photos')))
                ->filter(fn($f) => in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png']))
            : collect();
    @endphp
    @if ($galleryImages->isNotEmpty())
        <div class="container my-4">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach ($galleryImages as $img)
                    @php
                        $fileName = $img->getFilename();
                        $title = 'Photo ' . ($loop->iteration);
                        $src = asset('photos/' . $fileName);
                        $modalId = 'galleryModal' . $loop->index;
                    @endphp
                    <div class="col text-center">
    <a href="#" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
        <img src="{{ $src }}" class="img-fluid rounded shadow-sm" alt="{{ $title }}" style="max-height: 180px; object-fit: cover; width: 100%;" loading="lazy">
    </a>

    <!-- Modal -->
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body p-0">
                    <img src="{{ $src }}" class="img-fluid w-100" alt="{{ $title }}">
                </div>
            </div>
        </div>
    </div>
</div>

                @endforeach
            </div>
        </div>
    @else
        <p>No images found.</p>
    @endif
    @auth
        @if(!$property->closed && $property->end_at->isFuture())
        <form action="{{ route('bid.store') }}" method="POST" class="mb-4">
            @csrf
            <label for="amount" class="block mb-2">Montant de l'enchère (min {{ number_format(($highestBid?->amount ?? $property->starting_price - $property->min_increment) + $property->min_increment,0,',',' ') }} €)</label>
            <input type="number" name="amount" id="amount" required class="border p-2" />
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white">Enchérir</button>
        </form>
        @else
            <p class="text-red-600 font-bold">La vente est terminée.</p>
        @endif
    @else
        <p><a href="{{ route('login') }}" class="text-blue-500 underline">Connectez-vous</a> pour enchérir.</p>
    @endauth

    <h2 class="text-xl font-bold mt-8 mb-2">Historique des enchères</h2>
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

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('data-bs-target'));
            const modal = new bootstrap.Modal(target);
            modal.show();
        });
    });
});

</script>
@endpush

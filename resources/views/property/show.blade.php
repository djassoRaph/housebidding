@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="container my-4" style="all: unset; display: block;">
        <div class="row align-items-start">
            <!-- LEFT: Property Info -->
            <div id="left" class="col-12 col-md-7 mb-4 mb-md-0">
                <h1 class="text-2xl font-bold mb-4">{{ $property->title }}</h1>
                <p class="mb-2">{{ $property->description }}</p>
                <p class="mb-2"><strong>Lieu :</strong> {{ $property->location }}</p>
                <p class="mb-2"><strong>Fin des offres :</strong> {{ $property->end_at->format('d/m/Y H:i') }}</p>
                <p class="mb-4"><strong>Offre actuelle :</strong> {{ $highestBid ? number_format($highestBid->amount,0,',',' ') . ' €' : 'Aucune' }}</p>
            </div>

            <!-- RIGHT: Plan image or fallback -->
            <div id="right" class="col-12 col-md-5 d-flex justify-content-center align-items-center">
                <div id="plans" class="border p-2 text-center">
                    @if(file_exists(public_path('photos/plan.jpg')))
                        <img src="{{ asset('photos/plan.jpg') }}" alt="Plan de l'appartement" class="img-fluid rounded shadow-sm" style="max-width: 400px;">
                    @else
                        <p class="text-muted m-0">Plan non disponible.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @php
        use Illuminate\Support\Facades\File;
        $galleryImages = File::exists(public_path('photos'))
            ? collect(File::files(public_path('photos')))
                ->filter(fn($f) => in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png']))
            : collect();
    @endphp

    @if ($galleryImages->isNotEmpty())
    <div class="container my-4 px-3">
        <div class="gallery-grid">
            @foreach ($galleryImages as $img)
                @php
                    $fileName = $img->getFilename();
                    $title = 'Photo ' . ($loop->iteration);
                    $src = asset('photos/' . $fileName);
                @endphp
                <a href="{{ $src }}" class="glightbox gallery-square" data-gallery="property" data-title="{{ $title }}">
                    <img src="{{ $src }}" alt="{{ $title }}">
                </a>
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
            <label for="amount" class="block mb-2">Montant de l'offre (min {{ number_format(($highestBid?->amount ?? $property->starting_price - $property->min_increment) + $property->min_increment,0,',',' ') }} €)</label>
            <input type="number" name="amount" id="amount" required class="border p-2" />
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white">Enchérir</button>
        </form>
        @else
            <p class="text-red-600 font-bold">La vente est terminée.</p>
        @endif
    @else
        <p><a href="{{ route('login') }}" class="text-blue-500 underline">Connectez-vous</a> pour faire une offre.</p>
    @endauth

    <h2 class="text-xl font-bold mt-8 mb-2">Historique des offres</h2>
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
    const carouselElement = document.getElementById('galleryCarousel');
    if (!carouselElement) return;

    const carousel = new bootstrap.Carousel(carouselElement);
    const modalElement = document.getElementById('galleryCarouselModal');

    modalElement.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        if (trigger && trigger.dataset.bsSlideTo) {
            carousel.to(parseInt(trigger.dataset.bsSlideTo));
        }
    });
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const modalEl = document.getElementById('galleryCarouselModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }
});
</script>
@endpush

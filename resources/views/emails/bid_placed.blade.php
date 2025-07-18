<x-mail::message>
# Nouvelle offre confirmée

Vous avez placé une offre de **{{ number_format($bid->amount, 0, ',', ' ') }} €** le {{ $bid->created_at->format('d/m/Y H:i') }}.

Merci de votre participation.

<x-mail::button :url="url('/')">
Voir la vente
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>

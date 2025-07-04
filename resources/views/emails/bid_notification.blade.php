<x-mail::message>
# Nouvelle offre reçue

L'utilisateur {{ $bid->user->name }} a proposé **{{ number_format($bid->amount, 0, ',', ' ') }} €** le {{ $bid->created_at->format('d/m/Y H:i') }}.

<x-mail::button :url="url('/')">
Voir la vente
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>

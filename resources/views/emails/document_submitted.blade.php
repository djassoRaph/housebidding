<x-mail::message>
# Nouveau justificatif soumis

L'utilisateur {{ $user->name }} ({{ $user->email }}) a envoyé un justificatif de solvabilité.

<x-mail::button :url="url('/admin')">
Voir le tableau de bord
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>

@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto p-4">
<h1 class="text-2xl font-bold mb-4">Conditions d'utilisation</h1>
<p>Enchérissez de manière responsable. Contact: {{ config('mail.owner_address') }}</p>
</div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/js/app.js'])
    </head>
    <body>
        <div class=”nativephp-safe-area”>
            <h1>Liste des cours</h1>

            @forelse($cours as $c)
                <div style="margin-bottom: 16px; border: 1px solid #ccc; padding: 12px;">
                    <p><strong>Matière :</strong> {{ $c['matiere'] ?? '' }}</p>
                    <p><strong>Date :</strong> {{ $c['date'] ?? '' }}</p>
                    <p><strong>Heure début :</strong> {{ $c['heure_debut'] ?? '' }}</p>
                    <p><strong>Heure fin :</strong> {{ $c['heure_fin'] ?? '' }}</p>
                    <p><strong>Salle :</strong> {{ $c['salle'] ?? '' }}</p>
                    <p><strong>Professeur :</strong> {{ $c['professeur'] ?? '' }}</p>
                    <a href="{{ route('signature') }}/{{ $c['id'] }}">Signer</a>
                </div>
            @empty
                <p>Aucun cours trouvé.</p>
            @endforelse
        </div>
    </body>
</html>

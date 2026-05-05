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
            <h1>Page signature</h1>

            <div style="margin-bottom: 16px; border: 1px solid #ccc; padding: 12px;">
                <p><strong>Matière :</strong> {{ $cours['matiere'] ?? '' }}</p>
                <p><strong>Date :</strong> {{ $cours['date'] ?? '' }}</p>
                <p><strong>Heure début :</strong> {{ $cours['heure_debut'] ?? '' }}</p>
                <p><strong>Heure fin :</strong> {{ $cours['heure_fin'] ?? '' }}</p>
                <p><strong>Salle :</strong> {{ $cours['salle'] ?? '' }}</p>
                <p><strong>Professeur :</strong> {{ $cours['user']['name'] ?? '' }} {{ $cours['user']['prenom'] ?? '' }}</p>
            </div>

            <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>

            <div>
                <form method="POST" action="{{ route('signature.store') }}" id="signature-form">
                    @csrf
                    <input type="hidden" name="cours_id" value="{{ $cours['id'] }}">
                    <input type="hidden" name="signature" id="signature_input">

                    <button type="button" id="save">Enregistrer</button>
                    <button type="button" id="clear">Effacer</button>
                </form>

            </div>

            @if (session('error'))
                <p>{{ session('error') }}</p>
            @endif

        </div>
    </body>
</html>

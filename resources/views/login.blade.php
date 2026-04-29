@extends('layouts.base')

@section('title')
    Login
@endsection

@section('content')
    <h1>Login page</h1>

    {{-- Show a generic error message if needed --}}
    @if (session('error'))
        <div class="alert">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                required
                autofocus
            >
        </div>

        <div class="field">
            <label for="password">Mot de passe</label>
            <input
                id="password"
                type="password"
                name="password"
                required
            >
        </div>

        <button type="submit" class="btn">
            Connexion
        </button>
    </form>


@endsection

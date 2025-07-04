<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-2">
        {{-- Left side --}}
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" class="h-10 object-contain" alt="Logo" style="max-height: 40px; object-fit: contain;">
        </div>

        {{-- Center CTA --}}
        @guest
            <div class="text-center flex-grow-1">
                <span class="text-danger fw-bold">
                    Ce bien vous intéresse ? <a href="{{ route('register') }}" class="text-decoration-underline">Créez un compte, cliquez ici</a>
                </span>
            </div>
        @endguest

        {{-- Right side --}}
        <div class="d-flex align-items-center">
            @auth
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Se déconnecter</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Se connecter</a>
            @endauth
        </div>
    </div>
</nav>

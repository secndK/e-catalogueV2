<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <ul class="navbar-nav ms-auto align-items-center">


        @auth
            @if (Auth::user()->role === 'admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Photo de profil par défaut -->
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->mat_ag) }}&background=random&color=fff&rounded=true"
                            class="rounded-circle me-2 text-white" width="32" height="32" alt="Avatar">
                        <span>{{ Auth::user()->mat_ag }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @elseif(Auth::user()->role === 'user')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Photo de profil par défaut -->
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->mat_ag) }}&background=random&color=fff&rounded=true"
                            class="rounded-circle me-2 text-white" width="32" height="32" alt="Avatar">
                        <span>{{ Auth::user()->mat_ag }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <span class="nav-link text-muted">Invité</span>
                </li>
            @endif
        @endauth
    </ul>

</nav>

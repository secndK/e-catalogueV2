<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="#">
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-header">Menu Principal</li>


            @auth
                @if (Auth::user()->role === 'admin')
                    <li class="sidebar-item"> {{-- Assurez-vous que "Stats" est dans un li --}}
                        <a class="sidebar-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door-fill"></i>
                            <span class="align-middle">Accueil</span>
                        </a>
                    </li>
                @endif

                {{-- Le lien "Nouvelle Application" est un modal, il n'a pas besoin de devenir actif en fonction de l'URL --}}

            @endauth
            <li class="sidebar-item"> {{-- "Accueil" est déjà dans un li, c'est bon --}}
                <a class="sidebar-link" href="{{ route('catalogue') }}">
                    <i class="bi bi-window-stack"></i>
                    <span class="align-middle">Applications</span>
                </a>
            </li>

            @if ($recentSearches->count())
                <li class="sidebar-header recent-searches-header">
                    <i class="bi bi-clock-history me-2"></i> Recherches Récentes
                </li>

                @foreach ($recentSearches as $search)
                    <li class=" recent-search-item">
                        <a class="sidebar-link recent-search-link">
                            <i class="bi bi-search me-2"></i>
                            <span>{{ $search->search_term }}</span>
                            <small class="text-muted ms-2">({{ $search->results_count }} résultats)</small>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>

        <div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2">E-CATALOGUE v1.0</strong>
                <div class="mb-3 text-sm">Système de gestion des applications</div>

                @if ($recentSearches->count())
                    <form method="POST" action="{{ route('clear.search.history') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger clear-searches-btn" title="Effacer l'historique">
                            <i class="bi bi-trash me-1"></i> Effacer l'historique
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const currentPath = window.location.pathname;

        // Sélectionnez tous les liens de la barre latérale qui ne sont pas des modals
        const sidebarLinks = document.querySelectorAll('#sidebar .sidebar-link:not([data-bs-toggle="modal"])');

        sidebarLinks.forEach(link => {
            let linkHref = link.getAttribute('href');

            if (linkHref) {
                const url = new URL(linkHref, window.location.origin);
                linkHref = url.pathname;
            }

            // Comparaison exacte du chemin
            if (linkHref === currentPath) {
                // Supprime la classe 'active' de tous les autres éléments pour éviter les doublons
                document.querySelectorAll('#sidebar .sidebar-item.active').forEach(item => item
                    .classList.remove('active'));
                document.querySelectorAll('#sidebar .sidebar-link.active').forEach(lnk => lnk.classList
                    .remove('active'));


                link.classList.add('active');
                let parentItem = link.closest('.sidebar-item');
                if (parentItem) {
                    parentItem.classList.add('active');
                }
            }
            // Cas spécifique pour la route 'catalogue' qui peut être la racine ou avoir des paramètres
            if (linkHref === "{{ route('catalogue') }}" && (currentPath === "/catalogue" ||
                    currentPath === "/")) {
                // Supprime la classe 'active' de tous les autres éléments
                document.querySelectorAll('#sidebar .sidebar-item.active').forEach(item => item
                    .classList.remove('active'));
                document.querySelectorAll('#sidebar .sidebar-link.active').forEach(lnk => lnk.classList
                    .remove('active'));

                link.classList.add('active');
                let parentItem = link.closest('.sidebar-item');
                if (parentItem) {
                    parentItem.classList.add('active');
                }
            }
        });

        // Cas particulier pour les liens de recherche récente :
        const recentSearchLinks = document.querySelectorAll('.recent-search-link');
        recentSearchLinks.forEach(link => {
            // Compare l'URL complète pour les recherches récentes
            if (link.href === window.location.href) {
                // Supprime la classe 'active' de tous les autres liens d'abord
                document.querySelectorAll('#sidebar .sidebar-item.active').forEach(item => item
                    .classList.remove('active'));
                document.querySelectorAll('#sidebar .sidebar-link.active').forEach(lnk => lnk.classList
                    .remove('active'));

                link.classList.add('active');
                let parentItem = link.closest('.sidebar-item');
                if (parentItem) {
                    parentItem.classList.add('active');
                }
            }
        });
    });
</script>

<style>
    /* Vos styles CSS restent les mêmes */
    .sidebar-link.active,
    .sidebar-item.active>.sidebar-link {
        background-color: rgba(13, 110, 253, 0.1);
        /* Un fond légèrement bleuté pour l'état actif */
        color: #0d6efd;
        /* Couleur primaire pour le texte actif */
        font-weight: 600;
        /* Rendre le texte gras */
        border-left-color: #0d6efd;
        /* Bordure de gauche colorée pour indiquer l'actif */
    }

    /* ... Reste de votre CSS pour la sidebar ... */
</style>

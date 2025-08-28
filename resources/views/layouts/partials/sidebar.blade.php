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

            @endauth
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('catalogue') }}">
                    <i class="bi bi-window-stack"></i>
                    <span class="align-middle">Applications</span>
                </a>
            </li>



        </ul>
        <div class="sidebar-cta">
            <div class="sidebar-cta-content d-flex flex-column align-items-center">
                <strong class="d-inline-block mb-2">
                    <i class="fas fa-rocket"></i> E-CATALOGUE
                </strong>
                <button class="btn btn-primary disabled text-sm" disabled>
                    DEV IT - AOÛT 2025
                </button>
            </div>
        </div>
    </div>
</nav>


{{-- =====================================================SCRIPTS POUR LES ACTIVES+++++++++++++++++++++++++++++++++++++++++++++ --}}

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

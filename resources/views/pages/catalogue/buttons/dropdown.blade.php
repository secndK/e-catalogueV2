<div class="dropdown">
    <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <button class="dropdown-item view-app" data-bs-toggle="modal"
                data-bs-target="#appDetailsModal{{ $app->id }}">
                <i class="bi bi-eye text-info me-2"></i>Voir les détails
            </button>
        </li>
        @auth
            @if (Auth::user()->role === 'admin')
                <li>
                    @include('pages.catalogue.buttons.modifier')

                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <button class="dropdown-item text-danger delete-app" data-id="{{ $app->id ?? '' }}"
                        data-name="{{ $app->app_name ?? '' }}">
                        <i class="bi bi-trash me-2"></i>Supprimer
                    </button>
                </li>
            @endif
        @endauth
    </ul>
</div>

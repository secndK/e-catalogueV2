@extends('layouts.app')

@section('title', 'APPLICATIONS')
@section('text', 'RETROUVEZ L\'ENSEMBLE DES APPLICATIONS DU CATALOGUE ICI')

@section('content')
    <div class="bg-light min-vh-100 py-5">
        <div class="container">


            <!-- Barre de recherche professionnelle -->

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('catalogue') }}" method="POST">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-primary text-white border-primary">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <input type="text" name="rechercher" class="form-control border-primary"
                                                placeholder="Rechercher une application..."
                                                value="{{ old('rechercher', $search_query ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="bi bi-search me-2"></i>Rechercher
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary btn-lg w-100">
                                            <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Grille des applications - Style Corporate -->
            <div class="row g-4 mb-5">
                @forelse($catalogue as $app)
                    <div class="col-xl-4 col-lg-6">
                        <div class="card border-0 shadow h-100 corporate-card">
                            <!-- Header de card -->
                            <div class="card-header bg-primary text-white border-0 position-relative">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">

                                        <div>
                                            <h5 class="mb-0 fw-bold text-white">{{ $app->app_name ?? 'Application' }}</h5>

                                        </div>
                                    </div>

                                    <!-- Menu dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-outline-light btn-sm" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item view-app" data-bs-toggle="modal"
                                                    data-bs-target="#appDetailsModal{{ $app->id ?? '' }}">
                                                    <i class="bi bi-eye text-info me-2"></i>Voir les détails
                                                </button>
                                            </li>
                                            @auth
                                                @if (Auth::user()->role === 'admin')
                                                    <li>
                                                        <button class="dropdown-item edit-app"
                                                            data-app-id="{{ $app->id ?? '' }}"
                                                            data-app-data='@json($app)' data-bs-toggle="modal"
                                                            data-bs-target="#editAppModal">
                                                            <i class="bi bi-pencil text-warning me-2"></i>Modifier
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item text-danger delete-app"
                                                            data-app-id="{{ $app->id ?? '' }}"
                                                            data-app-name="{{ $app->app_name ?? '' }}">
                                                            <i class="bi bi-trash me-2"></i>Supprimer
                                                        </button>
                                                    </li>
                                                @endif
                                            @endauth
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <!-- URL principale -->
                                @if (!empty($app->url_app))
                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-semibold small mb-1">URL D'ACCÈS</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-globe text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 bg-light"
                                                value="{{ $app->url_app }}" readonly>
                                            <a href="{{ $app->url_app }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <!-- Environnements -->
                                <div class="mb-3">
                                    <label class="form-label text-muted fw-semibold small mb-2">ENVIRONNEMENTS</label>
                                    <div class="row g-2">
                                        @if (!empty($app->adr_serv_prod))
                                            <div class="col-12">
                                                <div
                                                    class="bg-success bg-opacity-10 border border-success border-opacity-25 rounded p-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-success me-2">PROD</span>
                                                            <small class="text-muted">{{ $app->adr_serv_prod }}</small>
                                                        </div>
                                                        <i class="bi bi-check-circle text-success"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!empty($app->adr_serv_test))
                                            <div class="col-12">
                                                <div
                                                    class="bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded p-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-warning text-dark me-2">TEST</span>
                                                            <small class="text-muted">{{ $app->adr_serv_test }}</small>
                                                        </div>
                                                        <i class="bi bi-exclamation-triangle text-warning"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (!empty($app->adr_serv_dev))
                                            <div class="col-12">
                                                <div
                                                    class="bg-info bg-opacity-10 border border-info border-opacity-25 rounded p-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-info text-dark me-2">DEV</span>
                                                            <small class="text-muted">{{ $app->adr_serv_dev }}</small>
                                                        </div>
                                                        <i class="bi bi-code-slash text-info"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Ressources additionnelles -->
                                @if (!empty($app->url_doc) || !empty($app->url_git))
                                    <div class="mb-0">
                                        <label class="form-label text-muted fw-semibold small mb-2">RESSOURCES</label>
                                        <div class="d-grid gap-2">
                                            @if (!empty($app->url_doc))
                                                <a href="{{ $app->url_doc }}" target="_blank"
                                                    class="btn btn-outline-secondary btn-sm text-start">
                                                    <i class="bi bi-file-earmark-text me-2"></i>
                                                    Documentation technique
                                                    <i class="bi bi-box-arrow-up-right ms-auto"></i>
                                                </a>
                                            @endif
                                            @if (!empty($app->url_git))
                                                <a href="{{ $app->url_git }}" target="_blank"
                                                    class="btn btn-outline-dark btn-sm text-start">
                                                    <i class="bi bi-github me-2"></i>
                                                    Dépôt de code source
                                                    <i class="bi bi-box-arrow-up-right ms-auto"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>


                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-folder2-open display-1 text-muted"></i>
                                </div>
                                <h4 class="text-dark fw-bold mb-3">Aucune application disponible</h4>
                                <p class="text-muted mb-4">
                                    Aucune application ne correspond aux critères de recherche .<br>

                                </p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('catalogue') }}" class="btn btn-primary">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse



                @if ($catalogue->hasPages())
                    <div class="col mt-4">
                        {{-- Texte d'information --}}
                        <div class="mb-2">
                            <p class="text-muted small">
                                Affichage de <span class="fw-bold">{{ $catalogue->firstItem() }}</span>
                                à <span class="fw-bold">{{ $catalogue->lastItem() }}</span>
                                sur <span class="fw-bold">{{ $catalogue->total() }}</span> résultats
                            </p>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-start">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    {{-- Bouton Previous --}}
                                    @if ($catalogue->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $catalogue->appends(request()->query())->previousPageUrl() }}">Previous</a>
                                        </li>
                                    @endif

                                    {{-- Numéros de pages --}}
                                    @foreach ($catalogue->getUrlRange(1, $catalogue->lastPage()) as $page => $url)
                                        @if ($page == $catalogue->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $catalogue->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Bouton Next --}}
                                    @if ($catalogue->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $catalogue->appends(request()->query())->nextPageUrl() }}">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif



            </div>

            <!-- Pagination professionnelle -->

        </div>
    </div>

    <!-- Styles CSS Corporate -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .corporate-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .corporate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-left-color: var(--bs-primary);
        }

        .bg-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .card-header {
            border-bottom: none;
        }

        .form-label {
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .badge {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn-outline-secondary {
            border-color: #e9ecef;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .input-group-text {
            font-weight: 500;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card-footer {
            background-color: #f8f9fa !important;
        }

        .text-white-50 {
            opacity: 0.7;
        }
    </style>
@endsection

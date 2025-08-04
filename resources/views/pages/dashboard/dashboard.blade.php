@extends('layouts.app')
@section('title', 'TABLEAU DE BOARD')
@section('text', 'RETROUVEZ L\'ENSEMBLE DES STATISTIQUES DU CATALOGUE ICI')

@section('content')
    <style>
        .stat-card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease-in-out;
            border: none;
            /* Padding encore plus réduit */
            padding: 0.75rem !important;
        }

        .stat-card:hover {
            transform: translateY(-0.125rem);
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            /* Taille de police réduite pour le nombre */
            font-size: 1.25rem;
            font-weight: 600;
            color: #0d6efd;
        }

        .stat-title {
            color: #6c757d;
            /* Taille de police encore plus réduite pour le titre */
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .stat-icon {
            /* Taille d'icône réduite */
            font-size: 1.1rem;
            color: #0d6efd;
            margin-bottom: 0.25rem;
        }

        /* Réductions supplémentaires pour les marges et paddings */
        .stat-card .mb-3 {
            margin-bottom: 0.5rem !important;
        }

        .stat-card .mb-2 {
            margin-bottom: 0.25rem !important;
        }

        .stat-card .mb-1 {
            margin-bottom: 0.125rem !important;
        }

        .stat-card .py-2 {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }

        .stat-card .py-1 {
            padding-top: 0.125rem !important;
            padding-bottom: 0.125rem !important;
        }

        .stat-card .pt-1 {
            padding-top: 0.125rem !important;
        }

        .stat-card .mt-2 {
            margin-top: 0.25rem !important;
        }

        /* Badge plus petit */
        .badge {
            font-size: 0.65rem;
            padding: 0.2em 0.4em;
        }

        /* Progress bar plus fine */
        .progress {
            height: 3px !important;
        }

        /* Texte plus petit pour les labels */
        .text-muted {
            font-size: 0.7rem;
        }

        /* Container plus compact */
        .container {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        /* Espacement réduit entre les rangées */
        .row {
            margin-bottom: 0.5rem;
        }
    </style>



    <div class="container-fluid p-5">

        {{-- Première ligne de cartes --}}
        <div class="row">

            <div class="col-md-4">
                <div class="stat-card h-100 p-2 text-center">
                    <div class="stat-icon">📱</div>
                    <div class="stat-title">Applications</div>
                    <div class="stat-number">{{ $total_applications }}</div>
                    <div class="progress mt-1" style="height: 3px;">
                        <div class="progress-bar bg-primary" role="progressbar"
                            style="width: {{ min(100, ($total_applications / 100) * 100) }}%"
                            aria-valuenow="{{ min(100, ($total_applications / 100) * 100) }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card h-100 p-2 text-center">
                    <div class="stat-icon">🌐</div>
                    <div class="stat-title">Environnements</div>
                    <div class="stat-number">{{ $total_environments }}</div>
                    <div class="progress mt-1" style="height: 3px;">
                        <div class="progress-bar bg-primary" role="progressbar"
                            style="width: {{ min(100, ($total_environments / 50) * 100) }}%"
                            aria-valuenow="{{ min(100, ($total_environments / 50) * 100) }}" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card h-100 p-2">
                    <div class="stat-icon text-center">📊</div>
                    <div class="stat-title text-center mb-1">Répartition Environement</div>
                    <div class="mb-1">
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">Dev</span>
                            <span class="badge rounded-pill bg-primary ms-auto">
                                {{ $environment_percentages['dev'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $environment_percentages['dev'] }}%"
                                aria-valuenow="{{ $environment_percentages['dev'] }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">Prod</span>
                            <span class="badge rounded-pill bg-success ms-auto">
                                {{ $environment_percentages['prod'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $environment_percentages['prod'] }}%"
                                aria-valuenow="{{ $environment_percentages['prod'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">Test</span>
                            <span class="badge rounded-pill bg-secondary ms-auto">
                                {{ $environment_percentages['test'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-secondary" role="progressbar"
                                style="width: {{ $environment_percentages['test'] }}%"
                                aria-valuenow="{{ $environment_percentages['test'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Deuxième ligne de cartes --}}
        <div class="row g-2 justify-content-center">
            <div class="col-md-4">
                <div class="stat-card h-100 p-2">
                    <div class="stat-icon text-center">🛠️</div>
                    <div class="stat-title text-center mb-1">Dev - Statut</div>
                    <div class="mb-1">
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">✅ Actif</span>
                            <span class="badge rounded-pill bg-success ms-auto">
                                {{ $status_percentages['dev']['actif'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status_percentages['dev']['actif'] }}%"
                                aria-valuenow="{{ $status_percentages['dev']['actif'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">❌ Inactif</span>
                            <span class="badge rounded-pill bg-danger ms-auto">
                                {{ $status_percentages['dev']['inactif'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $status_percentages['dev']['inactif'] }}%"
                                aria-valuenow="{{ $status_percentages['dev']['inactif'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card h-100 p-2">
                    <div class="stat-icon text-center">🚀</div>
                    <div class="stat-title text-center mb-1">Prod - Statut</div>
                    <div class="mb-1">
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">✅ Actif</span>
                            <span class="badge rounded-pill bg-success ms-auto">
                                {{ $status_percentages['prod']['actif'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status_percentages['prod']['actif'] }}%"
                                aria-valuenow="{{ $status_percentages['prod']['actif'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">❌ Inactif</span>
                            <span class="badge rounded-pill bg-danger ms-auto">
                                {{ $status_percentages['prod']['inactif'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $status_percentages['prod']['inactif'] }}%"
                                aria-valuenow="{{ $status_percentages['prod']['inactif'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card h-100 p-2">
                    <div class="stat-icon text-center">🧪</div>
                    <div class="stat-title text-center mb-1">Test - Statut</div>
                    <div class="mb-1">
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">✅ Actif</span>
                            <span class="badge rounded-pill bg-success ms-auto">
                                {{ $status_percentages['test']['actif'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status_percentages['test']['actif'] }}%"
                                aria-valuenow="{{ $status_percentages['test']['actif'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2 text-muted">❌ Inactif</span>
                            <span class="badge rounded-pill bg-danger ms-auto">
                                {{ $status_percentages['test']['inactif'] }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $status_percentages['test']['inactif'] }}%"
                                aria-valuenow="{{ $status_percentages['test']['inactif'] }}" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Troisième ligne pour les services critiques --}}
        <div class="row g-2 justify-content-center mt-2">
            <div class="col-md-6">
                <div class="stat-card h-100 p-2">
                    <div class="stat-icon text-center">⚡</div>
                    <div class="stat-title text-center mb-1">Services critiques récurents</div>
                    <ul class="list-unstyled mb-0">
                        @foreach ($top_critical_services as $service => $count)
                            <li class="d-flex align-items-center py-1 border-bottom border-light">
                                <span class="me-2 text-muted">🔥 {{ $service }}</span>
                                <span class="badge rounded-pill bg-danger ms-auto">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <!-- Bootstrap Bundle avec Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection

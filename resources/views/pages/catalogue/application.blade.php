@extends('layouts.app')
@section('title', 'APPLICATIONS')
@section('text', 'RETROUVEZ L\'ENSEMBLE DES APPLICATIONS DU CATALOGUE ICI')
@section('content')

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


    <div class="bg-light min-vh-100 py-5">
        <div class="container">
            <div class="d-flex justify-content-end align-items-center mb-4">
                <div class="row">
                    <!-- Lien Se connecter en tant qu'admin et apparait seulement que aux personnes qui ne sont pas connectées -->
                    {{-- @guest
                        <div class="admin-login-section">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="bi bi-person-badge me-2"></i>Se connecter
                            </a>
                        </div>
                    @endguest --}}

                    @auth
                        @if (Auth::user()->role === 'admin')
                            <div class="d-flex align-items-center">

                                <!-- Bouton dropdown avec menu -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Options
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#createAppModal">
                                                <i class="bi bi-plus-circle-fill"></i> Nouvelle Application
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('catalogue.export.all') }}">
                                                <i class="bi bi-download me-2"></i>Exporter catalogue
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#demandeServModal">
                                                <i class="bi bi-server me-2"></i>Demander serveur
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @include('pages.catalogue.modals.creation')
                            @include('pages.catalogue.modals.demande')
                        @endif
                    @endauth
                </div>
            </div>
            <!-- Barre de recherche professionnelle -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('catalogue.search') }}" method="POST">
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
                                    @include('pages.catalogue.buttons.dropdown')

                                </div>
                            </div>

                            <div class="card-body p-4">
                                @include('pages.catalogue.body-card.corps')

                            </div>

                        </div>
                    </div>

                    <!-- Modal de details -->

                    @include('pages.catalogue.modals.details')


                    <!-- Modal de modification -->
                    @include('pages.catalogue.modals.modification')



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
                                {{-- <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('catalogue') }}" class="btn btn-primary">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                                    </a>

                                </div> --}}
                            </div>
                        </div>
                    </div>
                @endforelse

            </div>

            @if ($catalogue->hasPages())
                @include('pages.catalogue.pagination.pagination')
            @endif

        </div>


    </div>

@endsection


@section('scripts')




    <script>
        document.addEventListener("DOMContentLoaded", function() {

            accordeonLogic();
            crud();
        });
    </script>


    <script>
        function accordeonLogic() {
            var accordionButtons = document.querySelectorAll('.accordion-button');
            accordionButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                });
            });

        }

        function crud() {
            /** LOGIQUE POUR LES SELECT 2 **/
            $(document).ready(function() {
                // Initialisation de tous les champs avec class="select-tags"
                $('.select-tags').select2({
                    tags: true,
                    width: '100%',
                    placeholder: "Sélectionner ou ajouter",
                    allowClear: true
                });

                $('#createAppModal').on('shown.bs.modal', function() {
                    $('.select-tags').select2({
                        tags: true,
                        width: '100%',
                        placeholder: "Sélectionner ou ajouter",
                        allowClear: true,
                        dropdownParent: $('#createAppModal')
                    });
                });


            });

            /**   CREE APPLICATION  **/
            $(document).ready(function() {
                $('#createAppForm').on('submit', function(e) {
                    e.preventDefault(); // Empêche le rechargement de page
                    let form = $(this);
                    let formData = new FormData(this);

                    Swal.fire({
                        title: 'Confirmer la création ',
                        text: "Voulez-vous vraiment créer cette application ?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, créer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Succès',
                                        text: response.message ||
                                            'Création réussie !',
                                        showConfirmButton: false,
                                        timer: 1500

                                    }).then(() => {
                                        location
                                            .reload(); // Tu peux aussi fermer un modal ici
                                    });
                                },
                                error: function(xhr) {
                                    let msg = "Une erreur est survenue.";
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        msg = xhr.responseJSON.message;
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: msg
                                    });
                                }
                            });
                        }
                    });
                });
            });

            /**   REMPLIR LES CHAMPS DU MODAL EDIT  **/

            $(document).on('click', '.edit-app', function() {
                // Récupérer les  pour le dev
                let id = $(this).data('id');
                let app_name = $(this).data('app_name');
                let desc_app = $(this).data('desc_app');
                let url_app = $(this).data('url_app');
                let url_doc = $(this).data('url_doc');
                let url_git = $(this).data('url_git');
                // Récupérer les  pour le dev
                let env_dev = $(this).data('env_dev');
                let url_dev = $(this).data('url_dev');
                let adr_serv_dev = $(this).data('adr_serv_dev');
                let nom_dns = $(this).data('nom_dns');
                let sys_exp_dev = $(this).data('sys_exp_dev');
                let vers_sys_dev = $(this).data('vers_sys_dev');
                let dist_sys_dev = $(this).data('dist_sys_dev');
                let adr_serv_bd_dev = $(this).data('adr_serv_bd_dev');
                let sys_exp_bd_dev = $(this).data('sys_exp_bd_dev');
                let nom_bd_dev = $(this).data('nom_bd_dev');
                let port_bd_dev = $(this).data('port_bd_dev');
                let user_bd_dev = $(this).data('user_bd_dev');
                let lang_deve_dev = $(this).data('lang_deve_dev');
                let vers_lang_dev = $(this).data('vers_lang_dev');
                let fram_dev = $(this).data('fram_dev');
                let vers_fram_dev = $(this).data('vers_fram_dev');
                let statut_dev = $(this).data('statut_dev');

                // recuperer les data de la prod
                let env_prod = $(this).data('env_prod');
                let url_prod = $(this).data('url_prod');
                let adr_serv_prod = $(this).data('adr_serv_prod');
                let sys_exp_prod = $(this).data('sys_exp_prod');
                let vers_sys_prod = $(this).data('vers_sys_prod');
                let dist_sys_prod = $(this).data('dist_sys_prod');
                let adr_serv_bd_prod = $(this).data('adr_serv_bd_prod');
                let sys_exp_bd_prod = $(this).data('sys_exp_bd_prod');
                let nom_bd_prod = $(this).data('nom_bd_prod');
                let port_bd_prod = $(this).data('port_bd_prod');
                let user_bd_prod = $(this).data('user_bd_prod');
                let lang_prode_prod = $(this).data('lang_prode_prod');
                let vers_lang_prod = $(this).data('vers_lang_prod');
                let fram_prod = $(this).data('fram_prod');
                let vers_fram_prod = $(this).data('vers_fram_prod');
                let statut_prod = $(this).data('statut_prod');

                // recupérer les data de la test
                let env_test = $(this).data('env_test');
                let url_test = $(this).data('url_test');
                let adr_serv_test = $(this).data('adr_serv_test');
                let sys_exp_test = $(this).data('sys_exp_test');
                let vers_sys_test = $(this).data('vers_sys_test');
                let dist_sys_test = $(this).data('dist_sys_test');
                let adr_serv_bd_test = $(this).data('adr_serv_bd_test');
                let sys_exp_bd_test = $(this).data('sys_exp_bd_test');
                let nom_bd_test = $(this).data('nom_bd_test');
                let port_bd_test = $(this).data('port_bd_test');
                let user_bd_test = $(this).data('user_bd_test');
                let lang_teste_test = $(this).data('lang_teste_test');
                let vers_lang_test = $(this).data('vers_lang_test');
                let fram_test = $(this).data('fram_test');
                let vers_fram_test = $(this).data('vers_fram_test');
                let statut_test = $(this).data('statut_test');


                // Configuration commune Select2
                const select2Config = {
                    tags: true,
                    width: '100%',
                    placeholder: "Sélectionner ou ajouter",
                    allowClear: true,
                    dropdownParent: $('#editAppModal')
                };

                // Traitement des services critiques pour les trois environnements
                ['dev', 'prod', 'test'].forEach(env => {
                    let $select = $(
                        `#edit_critical_${env}`
                    ); // on recupere les données passer pas le bouton modifier pour les 3
                    let rawCritical = $(this).attr(`data-critical_${env}`);
                    let parsed = [];

                    try {
                        parsed = JSON.parse(rawCritical || '[]'); // on parse le JSON en tableau ici
                    } catch (e) {
                        console.error(`Erreur parsing critical_${env}:`, e, rawCritical);

                    }

                    // console.log(`Valeurs critical_${env} parsées:`, parsed);  pour  verifier en console si les données on été bien parsée




                    // On vide complètement le <select> avant de le reconfigurer
                    // Puis on initialise/re-initialise Select2 avec les options globales définies ailleurs dans select2Config
                    // On lui injecte les données parsées sous forme d’objets {id, text}
                    $select.empty().select2({
                        ...select2Config,
                        data: parsed.map(item => ({
                            id: item,
                            text: item
                        }))

                        // On force la valeur du Select2 avec les données récupérées
                        // et on déclenche un "change"
                    }).val(parsed).trigger('change');
                });


                // Injection dans les champs du modal
                $('#edit_app_id').val(id);
                $('#edit_app_name').val(app_name);
                $('#edit_desc_app').val(desc_app);
                $('#edit_url_app').val(url_app);
                $('#edit_url_doc').val(url_doc);
                $('#edit_url_git').val(url_git);

                $('#edit_env_dev').val(env_dev);
                $('#edit_url_dev').val(url_dev);
                $('#edit_adr_serv_dev').val(adr_serv_dev);
                $('#nom_dns').val(nom_dns);
                $('#edit_sys_exp_dev').val(sys_exp_dev);
                $('#edit_vers_sys_dev').val(vers_sys_dev);
                $('#edit_dist_sys_dev').val(dist_sys_dev);
                $('#edit_adr_serv_bd_dev').val(adr_serv_bd_dev);
                $('#edit_sys_exp_bd_dev').val(sys_exp_bd_dev);
                $('#edit_nom_bd_dev').val(nom_bd_dev);
                $('#edit_port_bd_dev').val(port_bd_dev);
                $('#edit_user_bd_dev').val(user_bd_dev);
                $('#edit_lang_deve_dev').val(lang_deve_dev);
                $('#edit_vers_lang_dev').val(vers_lang_dev);
                $('#edit_fram_dev').val(fram_dev);
                $('#edit_vers_fram_dev').val(vers_fram_dev);
                $('#edit_statut_dev').val(statut_dev);

                $('#edit_env_prod').val(env_prod);
                $('#edit_url_prod').val(url_prod);
                $('#edit_adr_serv_prod').val(adr_serv_prod);
                $('#edit_sys_exp_prod').val(sys_exp_prod);
                $('#edit_vers_sys_prod').val(vers_sys_prod);
                $('#edit_dist_sys_prod').val(dist_sys_prod);
                $('#edit_adr_serv_bd_prod').val(adr_serv_bd_prod);
                $('#edit_sys_exp_bd_prod').val(sys_exp_bd_prod);
                $('#edit_nom_bd_prod').val(nom_bd_prod);
                $('#edit_port_bd_prod').val(port_bd_prod);
                $('#edit_user_bd_prod').val(user_bd_prod);
                $('#edit_lang_prode_prod').val(lang_prode_prod);
                $('#edit_vers_lang_prod').val(vers_lang_prod);
                $('#edit_fram_prod').val(fram_prod);
                $('#edit_vers_fram_prod').val(vers_fram_prod);
                $('#edit_statut_prod').val(statut_prod);

                $('#edit_env_test').val(env_test);
                $('#edit_url_test').val(url_test);
                $('#edit_adr_serv_test').val(adr_serv_test);
                $('#edit_sys_exp_test').val(sys_exp_test);
                $('#edit_vers_sys_test').val(vers_sys_test);
                $('#edit_dist_sys_test').val(dist_sys_test);
                $('#edit_adr_serv_bd_test').val(adr_serv_bd_test);
                $('#edit_sys_exp_bd_test').val(sys_exp_bd_test);
                $('#edit_nom_bd_test').val(nom_bd_test);
                $('#edit_port_bd_test').val(port_bd_test);
                $('#edit_user_bd_test').val(user_bd_test);
                $('#edit_lang_teste_test').val(lang_teste_test);
                $('#edit_vers_lang_test').val(vers_lang_test);
                $('#edit_fram_test').val(fram_test);
                $('#edit_vers_fram_test').val(vers_fram_test);
                $('#edit_statut_test').val(statut_test);
            });

            /** MODIFIER APPLICATION     **/

            $(document).ready(function() {
                $('#editAppForm').submit(function(e) {
                    e.preventDefault();

                    const id = $('#edit_app_id').val();
                    const formData = $(this).serialize();
                    const url = "{{ route('catalogue.update', ['id' => ':id']) }}".replace(':id', id);

                    Swal.fire({
                        title: 'Voulez-vous modifier cette application ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, je confirme',
                        cancelButtonText: 'Annuler',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',

                    }).then(result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: "POST", // POST + _method=PUT
                                data: formData,
                                success: function(response) {
                                    Swal.fire({

                                        icon: 'success',
                                        title: 'Succès',
                                        text: response.message ||
                                            'Modification réussie !',
                                        showConfirmButton: false, //pas de bouton OK
                                        timer: 1500 //disparaît après 1,5s


                                    }).then(() => location
                                        .reload()); // recharge après succès
                                },
                                error: function(xhr) {
                                    Swal.fire("Erreur",
                                        "Impossible de modifier l’application",
                                        "error");
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            location.reload(); // recharge aussi si on clique sur Annuler
                        }
                    });
                });
            });


            /**   SUPPRIMER APPLICATION  **/

            $(document).on('click', '.delete-app', function(e) {
                e.preventDefault();

                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: 'Confirmer la suppression',
                    text: `Voulez-vous vraiment supprimer l'application "${name}" ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('catalogue.delete', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Supprimée !',
                                    text: response.message ||
                                        'L\'application a été supprimée avec succès.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => location.reload()); // 🔄 recharge après succès
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: xhr.responseJSON?.message ||
                                        'Une erreur est survenue lors de la suppression.',
                                    icon: 'error'
                                }).then(() => location.reload()); // 🔄 recharge après erreur
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        location.reload(); // 🔄 recharge si on clique sur Annuler
                    }
                });
            });

            /** FAIRE UNE DEMANDE DE SERVEUR **/
            $(document).ready(function() {
                $('#demandeServForm').on('submit', function(e) {
                    e.preventDefault(); // Empêche le rechargement de page
                    let form = $(this);
                    let formData = new FormData(this);

                    // Confirmation avant envoi
                    Swal.fire({
                        title: 'Confirmer la demande',
                        text: "Voulez-vous vraiment soumettre cette demande de serveur ?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, soumettre',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Succès',
                                        text: response.message ||
                                            'Demande créée avec succès !',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        // Reset et fermeture du modal
                                        form[0].reset();
                                        $('#demandeServModal').modal('hide');
                                        location
                                            .reload(); // Actualisation de la page pour voir la nouvelle demande
                                    });
                                },
                                error: function(xhr) {
                                    let msg = "Une erreur est survenue.";
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        msg = xhr.responseJSON.message;
                                    }

                                    // Affichage des erreurs dans le div dédié
                                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                                        let errorsHtml = '<ul>';
                                        $.each(xhr.responseJSON.errors, function(key,
                                            value) {
                                            errorsHtml += '<li>' + value[0] +
                                                '</li>';
                                        });
                                        errorsHtml += '</ul>';
                                        $('#demandeServErrors').html(errorsHtml)
                                            .removeClass('d-none');
                                    } else {
                                        $('#demandeServErrors').html(msg).removeClass(
                                            'd-none');
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: msg
                                    });
                                }
                            });
                        }
                    });
                });
            });








        }
    </script>









@endsection

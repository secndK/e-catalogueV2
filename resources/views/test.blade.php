<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Test Select2 dans Modal</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

<body class="p-4">

    <h4>Test Select2 avec Tags dans un Modal</h4>

    <div class="mt-auto text-end">
        <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#createAppModal">
            <i class="bi bi-plus-circle-fill"></i> Nouvelle Application
        </a>
    </div>


    <div class="modal fade" id="createAppModal" tabindex="-1" aria-labelledby="createAppModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="createAppModalLabel">
                        <i class="bi bi-plus-circle-fill text-primary me-2"></i> Nouvelle Application
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <form action="{{ route('catalogue.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div id="createAppErrors" class="alert alert-danger d-none" role="alert"></div>

                        <div class="row g-3 mb-4 p-3 border rounded">
                            <h6 class="text-info fw-bold mb-3">
                                <i class="bi bi-info-circle me-1"></i> Informations Générales
                            </h6>
                            <div class="col-md-12">
                                <label for="app_name" class="form-label fw-bold">
                                    <i class="bi bi-box-seam me-1"></i> Nom de l'application<span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="app_name" name="app_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="desc_app" class="form-label fw-bold">
                                    <i class="bi bi-card-text me-1"></i> Description application
                                </label>
                                <input type="text" class="form-control" id="desc_app" name="desc_app">
                            </div>
                            <div class="col-md-6">
                                <label for="url_app" class="form-label fw-bold">
                                    <i class="bi bi-link-45deg me-1"></i> URL Application
                                </label>
                                <input type="url" class="form-control" id="url_app" name="url_app">
                            </div>
                            <div class="col-md-6">
                                <label for="url_doc" class="form-label fw-bold">
                                    <i class="bi bi-journal-text me-1"></i> URL Documentation
                                </label>
                                <input type="url" class="form-control" id="url_doc" name="url_doc">
                            </div>
                            <div class="col-md-6">
                                <label for="url_git" class="form-label fw-bold">
                                    <i class="bi bi-git me-1"></i> URL Git
                                </label>
                                <input type="url" class="form-control" id="url_git" name="url_git">
                            </div>
                        </div>

                        <!-- Environnement Développement -->
                        <div class="p-3 border rounded mb-4">
                            <h6 class="text-primary fw-bold mb-3">
                                <i class="bi bi-code-square me-1"></i> Environnement Développement
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="env_dev" class="form-label">Nom Environnement</label>
                                    <input type="text" class="form-control" id="env_dev" name="env_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="url_dev" class="form-label">URL Environnement</label>
                                    <input type="url" class="form-control" id="url_dev" name="url_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_dev" class="form-label">Adresse Serveur
                                        d'application</label>
                                    <input type="text" class="form-control" id="adr_serv_dev" name="adr_serv_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_dev" class="form-label">Système d'exploitation
                                        serveur
                                        d'application</label>
                                    <select class="form-control" id="sys_exp_dev" name="sys_exp_dev">
                                        <option value="">Choisir</option>
                                        <option value="Linux">Linux</option>
                                        <option value="Windows">Windows</option>
                                        <option value="Mac_Os">Mac Os</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dist_sys_dev" class="form-label">Distribution Système
                                        d'exploitation
                                        serveur d'application</label>
                                    <select class="form-control" id="dist_sys_dev" name="dist_sys_dev">
                                        <option value="">Choisir</option>
                                        <option value="Ubuntu" data-os="Linux">Ubuntu</option>
                                        <option value="Debian" data-os="Linux">Debian</option>
                                        <option value="CentOS" data-os="Linux">CentOS</option>
                                        <option value="Red Hat Enterprise Linux" data-os="Linux">Red Hat
                                            Enterprise Linux
                                        </option>
                                        <option value="Kali Linux" data-os="Linux">Kali Linux</option>
                                        <option value="Windows Server 2022" data-os="Windows">Windows
                                            Server 2022</option>
                                        <option value="Windows Server 2019" data-os="Windows">Windows
                                            Server 2019</option>
                                        <option value="Windows Server 2016" data-os="Windows">Windows
                                            Server 2016</option>
                                        <option value="macOS Server" data-os="Mac_Os">macOS Server
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_sys_dev" class="form-label">Version Système
                                        d'exploitation serveur
                                        d'application</label>
                                    <input type="text" class="form-control" id="vers_sys_dev"
                                        name="vers_sys_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_bd_dev" class="form-label">Adresse Base de
                                        données</label>
                                    <input type="text" class="form-control" id="adr_serv_bd_dev"
                                        name="adr_serv_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_bd_dev" class="form-label">Type de Base de
                                        données</label>
                                    <input type="text" class="form-control" id="sys_exp_bd_dev"
                                        name="sys_exp_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="nom_bd_dev" class="form-label">Nom de la Base de
                                        données</label>
                                    <input type="text" class="form-control" id="nom_bd_dev" name="nom_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="port_bd_dev" class="form-label">Port Base de
                                        données</label>
                                    <input type="text" class="form-control" id="port_bd_dev" name="port_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="user_bd_dev" class="form-label">Utilisateur Base de
                                        données</label>
                                    <input type="text" class="form-control" id="user_bd_dev" name="user_bd_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="lang_deve_dev" class="form-label">Langage de
                                        programmation</label>
                                    <input type="text" class="form-control" id="lang_deve_dev"
                                        name="lang_deve_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_lang_dev" class="form-label">Version Langage</label>
                                    <input type="text" class="form-control" id="vers_lang_dev"
                                        name="vers_lang_dev">
                                </div>

                                <div class="col-md-4">
                                    <label for="fram_dev" class="form-label"> Framework Langage de
                                        programmation</label>
                                    <input type="text" class="form-control" id="fram_dev" name="fram_dev">
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_fram_dev" class="form-label">Version
                                        Framework</label>
                                    <input type="text" class="form-control" id="vers_fram_dev"
                                        name="vers_fram_dev">

                                </div>
                                <div class="col-md-6">
                                    <label for="critical_dev" class="form-label">Service critique</label>
                                    <select id="critical_dev" name="critical_dev[]" class="select-tags form-control"
                                        multiple="multiple"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="statut_dev" class="form-label">Statut environnement
                                        Dev</label>
                                    <select id="statut_dev" name="statut_dev" class="form-control">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Environnement Test -->
                        <div class="p-3 border rounded mb-4">
                            <h6 class="text-warning fw-bold mb-3">
                                <i class="bi bi-bug me-1"></i> Environnement Test
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="env_test" class="form-label">Nom Environnement</label>
                                    <input type="text" class="form-control" id="env_test" name="env_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="url_test" class="form-label">URL Environnement</label>
                                    <input type="url" class="form-control" id="url_test" name="url_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_test" class="form-label">Adresse Serveur
                                        d'application</label>
                                    <input type="text" class="form-control" id="adr_serv_test"
                                        name="adr_serv_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_test" class="form-label">Système d'exploitation
                                        serveur
                                        d'application</label>
                                    <select class="form-control" id="sys_exp_test" name="sys_exp_test">
                                        <option value="">Choisir</option>
                                        <option value="Linux">Linux</option>
                                        <option value="Windows">Windows</option>
                                        <option value="Mac_Os">Mac Os</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dist_sys_test" class="form-label">Distribution Système
                                        d'exploitation
                                        serveur d'application</label>
                                    <select class="form-control" id="dist_sys_test" name="dist_sys_test">
                                        <option value="">Choisir</option>

                                        <option value="Ubuntu" data-os="Linux">Ubuntu</option>
                                        <option value="Debian" data-os="Linux">Debian</option>
                                        <option value="CentOS" data-os="Linux">CentOS</option>
                                        <option value="Red Hat Enterprise Linux" data-os="Linux">Red Hat
                                            Enterprise Linux
                                        </option>
                                        <option value="Kali Linux" data-os="Linux">Kali Linux</option>
                                        <option value="Windows Server 2022" data-os="Windows">Windows
                                            Server 2022</option>
                                        <option value="Windows Server 2019" data-os="Windows">Windows
                                            Server 2019</option>
                                        <option value="Windows Server 2016" data-os="Windows">Windows
                                            Server 2016</option>
                                        <option value="macOS Server" data-os="Mac_Os">macOS Server
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_sys_test" class="form-label">Version Système
                                        d'exploitation serveur
                                        d'application</label>
                                    <input type="text" class="form-control" id="vers_sys_test"
                                        name="vers_sys_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_bd_test" class="form-label">Adresse Base de
                                        données</label>
                                    <input type="text" class="form-control" id="adr_serv_bd_test"
                                        name="adr_serv_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_bd_test" class="form-label">Type de Base de
                                        données</label>
                                    <input type="text" class="form-control" id="sys_exp_bd_test"
                                        name="sys_exp_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="nom_bd_test" class="form-label">Nom de la Base de
                                        données</label>
                                    <input type="text" class="form-control" id="nom_bd_test" name="nom_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="port_bd_test" class="form-label">Port Base de
                                        données</label>
                                    <input type="text" class="form-control" id="port_bd_test"
                                        name="port_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="user_bd_test" class="form-label">Utilisateur Base de
                                        données</label>
                                    <input type="text" class="form-control" id="user_bd_test"
                                        name="user_bd_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="lang_deve_test" class="form-label">Langage de
                                        programmation</label>
                                    <input type="text" class="form-control" id="lang_deve_test"
                                        name="lang_deve_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_lang_test" class="form-label">Version Langage</label>
                                    <input type="text" class="form-control" id="vers_lang_test"
                                        name="vers_lang_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="fram_test" class="form-label"> Framework Langage de
                                        programmation</label>
                                    <input type="text" class="form-control" id="fram_test" name="fram_test">
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_fram_test" class="form-label">Version
                                        Framework</label>
                                    <input type="text" class="form-control" id="vers_fram_test"
                                        name="vers_fram_test">

                                </div>
                                <div class="col-md-6">
                                    <label for="critical_test" class="form-label">Service critique</label>
                                    <select id="critical_test" name="critical_test[]"
                                        class="form-control select-tags" multiple="multiple"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="statut_test" class="form-label">Statut environnement
                                        Test</label>
                                    <select id="statut_test" name="statut_test" class="form-control">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Environnement Production -->
                        <div class="p-3 border rounded mb-3">
                            <h6 class="text-success fw-bold mb-3">
                                <i class="bi bi-check-circle me-1"></i> Environnement Production
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="env_prod" class="form-label">Nom Environnement</label>
                                    <input type="text" class="form-control" id="env_prod" name="env_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="url_prod" class="form-label">URL Environnement</label>
                                    <input type="url" class="form-control" id="url_prod" name="url_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_prod" class="form-label">Adresse Serveur
                                        d'application</label>
                                    <input type="text" class="form-control" id="adr_serv_prod"
                                        name="adr_serv_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_prod" class="form-label">Système d'exploitation
                                        serveur
                                        d'application</label>
                                    <select class="form-control" id="sys_exp_prod" name="sys_exp_prod">
                                        <option value="">Choisir</option>
                                        <option value="Linux">Linux</option>
                                        <option value="Windows">Windows</option>
                                        <option value="Mac_Os">Mac Os</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dist_sys_prod" class="form-label">Distribution Système
                                        d'exploitation
                                        serveur d'application</label>
                                    <select class="form-control" id="dist_sys_prod" name="dist_sys_prod">
                                        <option value="">Choisir</option>
                                        <option value="Ubuntu" data-os="Linux">Ubuntu</option>
                                        <option value="Debian" data-os="Linux">Debian</option>
                                        <option value="CentOS" data-os="Linux">CentOS</option>
                                        <option value="Red Hat Enterprise Linux" data-os="Linux">Red Hat
                                            Enterprise Linux
                                        </option>
                                        <option value="Kali Linux" data-os="Linux">Kali Linux</option>
                                        <option value="Windows Server 2022" data-os="Windows">Windows
                                            Server 2022</option>
                                        <option value="Windows Server 2019" data-os="Windows">Windows
                                            Server 2019</option>
                                        <option value="Windows Server 2016" data-os="Windows">Windows
                                            Server 2016</option>
                                        <option value="macOS Server" data-os="Mac_Os">macOS Server
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_sys_prod" class="form-label">Version Système
                                        d'exploitation serveur
                                        d'application</label>
                                    <input type="text" class="form-control" id="vers_sys_prod"
                                        name="vers_sys_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="adr_serv_bd_prod" class="form-label">Adresse Base de
                                        données</label>
                                    <input type="text" class="form-control" id="adr_serv_bd_prod"
                                        name="adr_serv_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="sys_exp_bd_prod" class="form-label">Type de Base de
                                        données</label>
                                    <input type="text" class="form-control" id="sys_exp_bd_prod"
                                        name="sys_exp_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="nom_bd_prod" class="form-label">Nom de la Base de
                                        données</label>
                                    <input type="text" class="form-control" id="nom_bd_prod" name="nom_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="port_bd_prod" class="form-label">Port Base de
                                        données</label>
                                    <input type="text" class="form-control" id="port_bd_prod"
                                        name="port_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="user_bd_prod" class="form-label">Utilisateur Base de
                                        données</label>
                                    <input type="text" class="form-control" id="user_bd_prod"
                                        name="user_bd_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="lang_deve_prod" class="form-label">Langage de
                                        programmation</label>
                                    <input type="text" class="form-control" id="lang_deve_prod"
                                        name="lang_deve_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_lang_prod" class="form-label">Version Langage</label>
                                    <input type="text" class="form-control" id="vers_lang_prod"
                                        name="vers_lang_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="fram_prod" class="form-label"> Framework Langage de
                                        programmation</label>
                                    <input type="text" class="form-control" id="fram_prod" name="fram_prod">
                                </div>
                                <div class="col-md-4">
                                    <label for="vers_fram_prod" class="form-label">Version
                                        Framework</label>
                                    <input type="text" class="form-control" id="vers_fram_prod"
                                        name="vers_fram_prod">

                                </div>
                                <div class="col-md-6">
                                    <label for="critical_prod" class="form-label">Service critique</label>
                                    <select id="critical_prod" name="critical_prod[]"
                                        class="form-control select-tags" multiple="multiple"></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="statut_prod" class="form-label">Statut environnement
                                        Prod</label>
                                    <select id="statut_prod" name="statut_prod" class="form-control">
                                        <option value="">Sélectionner un statut</option>
                                        <option value="Actif">Actif</option>
                                        <option value="Inactif">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Important : init Select2 à chaque ouverture du modal
        $('#createAppModal').on('shown.bs.modal', function() {
            $('.select-tags').select2({
                tags: true,
                tokenSeparators: [','],
                width: '100%',
                placeholder: 'Sélectionnez ou ajoutez des tags',
                allowClear: true,
                dropdownParent: $('#createAppModal')
            });
        });

        // Affichage des tags soumis
        $('#formWithTags').on('submit', function(e) {
            e.preventDefault();
            const selectedTags = $('#select_tags').val();
            alert('Tags sélectionnés : ' + JSON.stringify(selectedTags));
        });
    </script>
</body>

</html>

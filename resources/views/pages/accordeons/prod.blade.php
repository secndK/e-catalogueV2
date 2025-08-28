<div class="accordion-item">
    <h2 class="accordion-header" id="headingProd{{ $app->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseProd{{ $app->id }}" aria-expanded="false"
            aria-controls="collapseProd{{ $app->id }}">
            Environnement PROD
        </button>
    </h2>
    <div id="collapseProd{{ $app->id }}" class="accordion-collapse collapse"
        aria-labelledby="headingProd{{ $app->id }}" data-bs-parent="#envAccordion{{ $app->id }}">
        <div class="accordion-body">
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                URL Prod
                            </th>
                            <td>
                                @if ($app->url_app)
                                    <a href="{{ $app->url_prod }} fw-bold" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        {{ $app->url_prod }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Adresse du Serveur d'Application
                            </th>
                            <td>
                                @if ($app->adr_serv_prod)
                                    {{ $app->adr_serv_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Système d'exploitation
                            </th>
                            <td>
                                @if ($app->sys_exp_prod)
                                    {{ $app->sys_exp_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Version du système
                            </th>
                            <td>
                                @if ($app->vers_sys_prod)
                                    {{ $app->vers_sys_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Distribution du système
                            </th>
                            <td>
                                @if ($app->dist_sys_prod)
                                    {{ $app->dist_sys_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Adresse du serveur BD
                            </th>
                            <td>
                                @if ($app->adr_serv_bd_prod)
                                    {{ $app->adr_serv_bd_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Système d'exploitation BD
                            </th>
                            <td>
                                @if ($app->sys_exp_bd_prod)
                                    {{ $app->sys_exp_bd_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Nom de la base de données
                            </th>
                            <td>
                                @if ($app->nom_bd_prod)
                                    {{ $app->nom_bd_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Port de la base de données
                            </th>
                            <td>
                                @if ($app->port_bd_prod)
                                    {{ $app->port_bd_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Utilisateur de la base de données
                            </th>
                            <td>
                                @if ($app->user_bd_prod)
                                    {{ $app->user_bd_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Langage de développement
                            </th>
                            <td>
                                @if ($app->lang_deve_prod)
                                    {{ $app->lang_deve_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Version du langage
                            </th>
                            <td>
                                @if ($app->vers_lang_prod)
                                    {{ $app->vers_lang_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Framework
                            </th>
                            <td>
                                @if ($app->fram_prod)
                                    {{ $app->fram_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Version du framework
                            </th>
                            <td>
                                @if ($app->vers_fram_prod)
                                    {{ $app->vers_fram_prod }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Service critique à surveiller
                            </th>
                            <td>
                                @if ($app->critical_prod)
                                    @foreach (json_decode($app->critical_prod, true) as $critical)
                                        <span class="badge bg-danger">{{ $critical }}</span>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Statut
                            </th>
                            <td>
                                @if ($app->statut_prod)
                                    <span class="badge bg-{{ $app->statut_prod === 'Actif' ? 'success' : 'warning' }}">
                                        {{ $app->statut_prod }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

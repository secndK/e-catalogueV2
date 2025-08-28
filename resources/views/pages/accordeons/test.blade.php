<div class="accordion-item">
    <h2 class="accordion-header" id="headingTest{{ $app->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseTest{{ $app->id }}" aria-expanded="false"
            aria-controls="collapseTest{{ $app->id }}">
            Environnement TEST
        </button>
    </h2>
    <div id="collapseTest{{ $app->id }}" class="accordion-collapse collapse" aria-labelledby="headingTest"
        data-bs-parent="#envAccordion{{ $app->id }}">
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
                                    <a href="{{ $app->url_test }} fw-bold" target="_blank"
                                        class="text-primary text-decoration-underline">
                                        {{ $app->url_test }}
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
                                @if ($app->adr_serv_test)
                                    {{ $app->adr_serv_test }}
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
                                @if ($app->sys_exp_test)
                                    {{ $app->sys_exp_test }}
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
                                @if ($app->vers_sys_test)
                                    {{ $app->vers_sys_test }}
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
                                @if ($app->dist_sys_test)
                                    {{ $app->dist_sys_test }}
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
                                @if ($app->adr_serv_bd_test)
                                    {{ $app->adr_serv_bd_test }}
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
                                @if ($app->sys_exp_bd_test)
                                    {{ $app->sys_exp_bd_test }}
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
                                @if ($app->nom_bd_test)
                                    {{ $app->nom_bd_test }}
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
                                @if ($app->port_bd_test)
                                    {{ $app->port_bd_test }}
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
                                @if ($app->user_bd_test)
                                    {{ $app->user_bd_test }}
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
                                @if ($app->lang_deve_test)
                                    {{ $app->lang_deve_test }}
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
                                @if ($app->vers_lang_test)
                                    {{ $app->vers_lang_test }}
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
                                @if ($app->fram_test)
                                    {{ $app->fram_test }}
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
                                @if ($app->vers_fram_test)
                                    {{ $app->vers_fram_test }}
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
                                @if ($app->critical_test)
                                    @foreach (json_decode($app->critical_test, true) as $critical)
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
                                @if ($app->statut_test)
                                    <span class="badge bg-{{ $app->statut_test === 'Actif' ? 'success' : 'warning' }}">
                                        {{ $app->statut_test }}
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

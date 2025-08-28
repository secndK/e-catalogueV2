<div class="accordion-item">
    <h2 class="accordion-header" id="headingDev{{ $app->id }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseDev{{ $app->id }}" aria-expanded="true"
            aria-controls="collapseDev{{ $app->id }}">
            Environnement DEV
        </button>
    </h2>
    <div id="collapseDev{{ $app->id }}" class="accordion-collapse collapse show"
        aria-labelledby="headingDev{{ $app->id }}" data-bs-parent="#envAccordion{{ $app->id }}">
        <div class="accordion-body">
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                URL DEV
                            </th>
                            <td>

                                <a href="{{ $app->url_dev }} fw-bold" target="_blank"
                                    class="text-primary text-decoration-underline">
                                    {{ $app->url_dev }}
                                </a>

                            </td>
                        </tr>


                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Adresse du Serveur d'Application
                            </th>
                            <td>

                                {{ $app->adr_serv_dev }}


                            </td>
                        </tr>



                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Nom de domaine
                            </th>
                            <td>

                                {{ $app->nom_dns }}


                            </td>
                        </tr>

                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Système d'exploitation
                            </th>
                            <td>
                                @if ($app->sys_exp_dev)
                                    {{ $app->sys_exp_dev }}
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
                                @if ($app->vers_sys_dev)
                                    {{ $app->vers_sys_dev }}
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
                                @if ($app->dist_sys_dev)
                                    {{ $app->dist_sys_dev }}
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
                                @if ($app->adr_serv_bd_dev)
                                    {{ $app->adr_serv_bd_dev }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-nowrap fw-bold">
                                Base de donnée
                            </th>
                            <td>
                                @if ($app->sys_exp_bd_dev)
                                    {{ $app->sys_exp_bd_dev }}
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
                                @if ($app->nom_bd_dev)
                                    {{ $app->nom_bd_dev }}
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
                                @if ($app->port_bd_dev)
                                    {{ $app->port_bd_dev }}
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
                                @if ($app->user_bd_dev)
                                    {{ $app->user_bd_dev }}
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
                                @if ($app->lang_deve_dev)
                                    {{ $app->lang_deve_dev }}
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
                                @if ($app->vers_lang_dev)
                                    {{ $app->vers_lang_dev }}
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
                                @if ($app->fram_dev)
                                    {{ $app->fram_dev }}
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
                                @if ($app->vers_fram_dev)
                                    {{ $app->vers_fram_dev }}
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
                                @if ($app->critical_dev)
                                    @foreach (json_decode($app->critical_dev, true) as $critical)
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
                                    <span class="badge bg-{{ $app->statut_dev === 'Actif' ? 'success' : 'warning' }}">
                                        {{ $app->statut_dev }}
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

 <div class="modal fade" id="appDetailsModal{{ $app->id }}" tabindex="-1"
     aria-labelledby="appDetailsModalLabel{{ $app->id }}" aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="appDetailsModalLabel{{ $app->id }}">Détails de
                     l'application : {{ $app->app_name ?? 'N/A' }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
             </div>
             <div class="modal-body">
                 <div class="row">

                     <div class="col-md-12">

                         <h6 class="mb-3">Informations Générales</h6>
                         <div class="table-responsive mb-4">
                             <table class="table table-bordered table-striped align-middle mb-0">
                                 <tbody>
                                     <tr>
                                         <th scope="row" class="text-nowrap fw-bold">Description
                                         </th>
                                         <td>{{ $app->desc_app ?? 'N/A' }}</td>
                                     </tr>
                                     <tr>
                                         <th scope="row" class="text-nowrap fw-bold ">URL
                                             Application</th>
                                         <td>
                                             @if ($app->url_app)
                                                 <a href="{{ $app->url_app }} fw-bold" target="_blank"
                                                     class="text-primary text-decoration-underline">
                                                     {{ $app->url_app }}
                                                 </a>
                                             @else
                                                 N/A
                                             @endif
                                         </td>
                                     </tr>
                                     <tr>
                                         <th scope="row" class="text-nowrap fw-bold">URL
                                             Documentation</th>
                                         <td>
                                             @if ($app->url_doc)
                                                 <a href="{{ $app->url_doc }}" target="_blank"
                                                     class="text-primary text-decoration-underline">
                                                     {{ $app->url_doc }}
                                                 </a>
                                             @else
                                                 N/A
                                             @endif
                                         </td>
                                     </tr>
                                     <tr>
                                         <th scope="row" class="text-nowrap fw-bold">URL Git</th>
                                         <td>
                                             @if ($app->url_git)
                                                 <a href="{{ $app->url_git }}" target="_blank"
                                                     class="text-primary text-decoration-underline">
                                                     {{ $app->url_git }}
                                                 </a>
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

                 {{-- ======================================ACCORDEON======================================================== --}}

                 <div class="accordion accordion-flush" id="envAccordion{{ $app->id }}">
                     <!-- DEV Environment -->

                     @include('pages.accordeons.dev')



                     <!-- PROD Environment -->
                     @include('pages.accordeons.prod')



                     <!-- TEST Environment -->

                     @include('pages.accordeons.test')


                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
             </div>
         </div>
     </div>
 </div>
